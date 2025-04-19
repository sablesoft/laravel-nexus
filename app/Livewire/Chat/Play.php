<?php

namespace App\Livewire\Chat;

use App\Livewire\PresenceTrait;
use App\Logic\Facades\Dsl;
use App\Logic\Facades\EffectRunner;
use App\Logic\Facades\NodeRunner;
use App\Logic\Process;
use App\Models\Application;
use App\Models\Chat;
use App\Models\ChatScreenState;
use App\Models\Control;
use App\Models\Enums\ChatStatus;
use App\Models\Enums\ControlType;
use App\Models\Character;
use App\Models\Memory;
use App\Models\Screen;
use App\Models\Transfer;
use App\Notifications\ChatPlaying;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * The Livewire component Chat\Play is the main client interface for user participation in a chat
 * launched from a user-defined application (Application). Visually, it represents a screen
 * with a message area, a multifunctional right sidebar, and a footer with interactive controls (transfers, actions, input).
 *
 * The component is built with Livewire and tightly integrated with real-time presence features via Laravel Reverb (Echo.presence),
 * as well as the platform's logic execution engine: Process, NodeRunner, DSL, memories, scenarios, and steps.
 *
 * ---
 * Environment:
 * - Uses Process as the primary execution context container
 * - Invokes NodeRunner to execute Transfers and Controls (actions, inputs)
 * - Applies Dsl::apply() to the Memory model, based on the current screen’s query (screen.query)
 * - Displays online/offline participants using the PresenceTrait
 */
#[Layout('components.layouts.play')]
class Play extends Component
{
    use PresenceTrait;

    const CHANNELS_PREFIX = 'play';
    const SCREEN_STATE_PREVIOUS = '__previous';

    #[Locked]
    public string $channelsPrefix = self::CHANNELS_PREFIX;

    /** The current chat instance */
    #[Locked]
    public Chat $chat;

    #[Locked]
    public Character $character;

    #[Locked]
    public Application $application;

    /** The currently active screen (defines transfers, controls, inputs) */
    #[Locked]
    public ?Screen $screen = null;

    #[Locked]
    public array $rawTransfers = [];

    #[Locked]
    public array $rawControls = [];

    /** Array of Transfer buttons rendered in the footer */
    #[Locked]
    public array $transfers;

    /** Array of Action buttons rendered in the footer */
    #[Locked]
    public array $actions;

    /** Array of Input controls rendered in the footer */
    #[Locked]
    public array $inputs;

    /** The currently active input control (used in input mode) */
    #[Locked]
    public ?array $activeInput;

    /** List of memory entries filtered by the screen's DSL query */
    #[Locked]
    public array $memories;

    /** The user input entered through the active input field */
    public string $ask = '';

    #[Locked]
    public bool $waiting = false;

    /** List of online characters (calculated via PresenceTrait) */
    #[Locked]
    public Collection $onlineCharacters;

    /** List of offline characters (calculated via PresenceTrait) */
    #[Locked]
    public Collection $offlineCharacters;

    protected function getListeners(): array
    {
        return [
            'usersHere' => 'here',
            'userJoining' => 'joining',
            'userLeaving' => 'leaving',
        ];
    }

    public function mount(int $id): void
    {
        $this->chat = Chat::with([
            'application.screens.controls.scenario',
            'application.screens.transfers',
            'characters.mask',
            'memories.character'
        ])->findOrFail($id);
        if (!$this->canPlay()) {
            $this->redirectRoute('chats.view', ['id' => $id], true, true);
        }
        $this->application = $this->chat->application;
        $this->character = $this->chat->takenSeats->where('user_id', auth()->id())->firstOrFail();
        $this->initCharacters();
        $this->initScreen($this->character->screen);
    }

    public function render(): mixed
    {
        return view('livewire.chat.play', [
            'presence' => [
                $this->chatChannel() => ['refresh.play' => 'refresh.play'],
                $this->screenChannel() => ['refresh.play' => 'refresh.play'],
            ]
        ])
            ->title('Chat Play: ' . $this->chat->title);
    }

    public function chatChannel(): string
    {
        return self::CHANNELS_PREFIX .'.'. $this->chat->id;
    }

    public function screenChannel(): string
    {
        return self::CHANNELS_PREFIX .'.'. $this->chat->id .'.'. $this->screen->id;
    }

    #[On('refresh.play')]
    public function refresh(): void
    {
        $this->waiting = false;
        $this->chat->load(['memories.author']);
        $this->prepareMemories();
        $this->prepareControls();
    }

    protected function initCharacters(): void
    {
        $this->offlineCharacters = $this->chat->takenSeats->filter(
            fn($character) => !in_array($character->user_id, $this->userIds[$this->chatChannel()] ?? [])
        );
        $this->onlineCharacters = $this->chat->takenSeats->filter(
            fn($character) => in_array($character->user_id,$this->userIds[$this->chatChannel()] ?? [])
        );
    }

    protected function initScreen(Screen $screen, bool $withHistory = true): void
    {
//        $this->waiting = false;
        if ($withHistory) {
            $this->screenState($screen->getKey())->setSystem(static::SCREEN_STATE_PREVIOUS, $this->screen?->getKey());
        }
        $this->screen = $screen;
        $this->rawTransfers = $screen->transfers->map(fn (Transfer $transfer) => [
            'id' => $transfer->id,
            'screen_to_id' => $transfer->screen_to_id,
            'title' => $transfer->title,
            'tooltip' => $transfer->tooltip,
            'visible_condition' => $transfer->visible_condition,
            'enabled_condition' => $transfer->enabled_condition,
        ])->toArray();

        $this->rawControls = $screen->controls->map(fn (Control $control) => [
            'id' => $control->id,
            'type' => $control->type->value,
            'title' => $control->title,
            'tooltip' => $control->tooltip,
            'visible_condition' => $control->visible_condition,
            'enabled_condition' => $control->enabled_condition,
        ])->toArray();

        if ($screen->init) {
            $process = $this->getProcess();
            $this->before($process);
            $process->media = $screen;
            EffectRunner::run($screen->init, $process);
            $this->after($process);
        }

        $this->prepareControls();
        $this->prepareMemories();
    }

    protected function prepareControls(): void
    {
        $this->transfers = $this->getTransfers();
        $this->actions = $this->getControls(ControlType::Action->value);
        $this->inputs = $this->getControls(ControlType::Input->value);
        $this->activeInput = reset($this->inputs) ?: null;
    }

    protected function prepareMemories(): void
    {
        $this->memories = collect($this->getMemories())->keyBy('id')->toArray();
    }

    protected function getTransfers(): array
    {
        $context = $this->getProcess()->toContext();
        return collect($this->rawTransfers)
            ->filter(fn ($t) => !$t['visible_condition'] || Dsl::evaluate($t['visible_condition'], $context))
            ->map(fn ($t) => [
                'id'            => $t['id'],
                'screen_to_id'  => $t['screen_to_id'],
                'title'         => $t['title'],
                'tooltip'       => $t['tooltip'],
                'enabled'       => !$t['enabled_condition'] || Dsl::evaluate($t['enabled_condition'], $context),
            ])->keyBy('id')->toArray();
    }

    protected function getControls(string $type): array
    {
        $context = $this->getProcess()->toContext();
        return collect($this->rawControls)
            ->filter(fn ($c) => $c['type'] === $type)
            ->filter(fn ($c) => !$c['visible_condition'] || Dsl::evaluate($c['visible_condition'], $context))
            ->map(fn ($c) => [
                'id' => $c['id'],
                'title' => $c['title'],
                'tooltip' => $c['tooltip'],
                'enabled' => !$c['enabled_condition'] || Dsl::evaluate($c['enabled_condition'], $context),
            ])->keyBy('id')->toArray();
    }


    protected function getMemories(): array
    {
        $query = Dsl::apply(Memory::query(), $this->screen->query, $this->getProcess()->toContext());
        return $query->with('author')->where('chat_id', $this->chat->id)
            ->orderBy('created_at')->get()
            ->map(fn(Memory $memory) => [
                'id' => $memory->id,
                'author_id' => $memory->author_id,
                'character_id' => $memory->character_id,
                'user_id' => $memory->author?->user_id,
                'mask_name' => $memory->author?->maskName,
                'image_id' => $memory->image_id,
                'title' => $memory->title,
                'content' => $memory->content,
                'type' => $memory->type,
                'meta' => $memory->meta,
                'created_at' => $memory->created_at
            ])->toArray();
    }

    /**
     * Handles the transition to another screen.
     *
     * Triggered when the user clicks a Transfer button in the footer.
     * Executes NodeRunner for the Transfer node. As a NodeContract, it may contain DSL-based
     * before/after blocks and nested logic. Currently, the screen transition happens unconditionally,
     * but this will be refined soon.
     */
    public function transfer(int $transferId): void
    {
        $transfer = $this->getTransfer($transferId);
        $process = $this->getProcess();
        $process->screenTransfer = $transfer->screen_to_id;

        $this->before($process);
        NodeRunner::run($transfer, $process);
        $this->after($process);
    }

    public function changeScreen(Screen $screen, bool $withHistory = true): void
    {
        $this->character->update(['screen_id' => $screen->getKey()]);
        $fromChannel = $this->screenChannel();
        $this->initScreen($screen, $withHistory);
        $toChannel = $this->screenChannel();
        $this->dispatch(
            'swap-presence',
            fromChannel: $fromChannel,
            toChannel: $toChannel,
            events: ['refresh.play' => 'refresh.play']
        );
    }

    /**
     * Handles user input submitted via the active input control.
     *
     * Passes the $ask value into the Process (under the 'ask' key), and runs NodeRunner
     * for the active input control. Clears $ask after execution.
     * Currently checks the `$refresh` flag in the Process and triggers refresh(), but this is
     * a temporary testing mechanism — in the future, all UI changes will be driven directly from the
     * process side and the component will only listen and react accordingly.
     */
    public function input(): void
    {
        $control = $this->getControl($this->activeInput['id']);
        $process = $this->getProcess([
            'ask' => $this->ask
        ]);
        $this->ask = '';

        $this->before($process);
        NodeRunner::run($control, $process);
        $this->after($process);
    }

    /**
     * Handles a click on an Action button on the current screen.
     *
     * Loads the corresponding control (a NodeContract) and runs it through NodeRunner.
     * The Process is created without user input but always includes the main logical entities.
     */
    public function action(int $controlId): void
    {
        $control = $this->getControl($controlId);
        $process = $this->getProcess();

        $this->before($process);
        NodeRunner::run($control, $process);
        $this->after($process);
    }

    /**
     * @throws \Exception
     */
    public function changeInput(int $controlId): void
    {
        if (!isset($this->inputs[$controlId])) {
            throw new \Exception('Input not found: ' . $controlId);
        }

        $this->activeInput = $this->inputs[$controlId];
    }

    protected function handleHere(string $channel): void
    {
        $this->initCharacters();

        $message = $this->character->maskName . __(' is playing ') .'"' . $this->chat->title . '"';
        $link = route('chats.play', ['id' => $this->chat->id]);
        /** @var Character $character */
        foreach ($this->offlineCharacters as $character) {
            $character->user->notifyNow(new ChatPlaying($message, $link));
        }
    }

    protected function handleJoining(string $channel, int $id): void
    {
        $this->initCharacters();
    }

    protected function handleLeaving(string $channel, int $id): void
    {
        $this->initCharacters();
    }

    public function close(): void
    {
        $this->redirectRoute('chats.view', ['id' => $this->chat->id], true, true);
    }

    protected function canPlay(): bool
    {
        return $this->chat->status === ChatStatus::Started &&
            !!$this->chat->characters->where('user_id', auth()->id())
                ->where('is_confirmed', true)->count();
    }

    protected function getTransfer(int $id): Transfer
    {
        return $this->screen->transfers->findOrFail($id);
    }

    protected function getControl(int $id): Control
    {
        return $this->screen->controls->findOrFail($id);
    }

    protected function before(Process $process): Process
    {
        if ($appBefore = $this->application->getBefore()) {
            $process->media = $this->application;
            EffectRunner::run($appBefore, $process);
        }
        if ($screenBefore = $this->screen->getBefore()) {
            $process->media = $this->screen;
            EffectRunner::run($screenBefore, $process);
        }

        return $process;
    }

    protected function after(Process $process): void
    {
        if ($screenAfter = $this->screen->getAfter()) {
            $process->media = $this->screen;
            EffectRunner::run($screenAfter, $process);
        }
        if ($appAfter = $this->application->getAfter()) {
            $process->media = $this->application;
            EffectRunner::run($appAfter, $process);
        }

        if ($process->screenWaiting) {
            $this->waiting = true;
        }
        if ($process->screenTransfer) {
            $this->changeScreen(Screen::findOrFail($process->screenTransfer));
            return;
        }
        if ($process->screenBack) {
            $id = $this->screenState()->getSystem(static::SCREEN_STATE_PREVIOUS);
            if ($id) {
                $this->screenState()->setSystem(static::SCREEN_STATE_PREVIOUS, null);
                $this->changeScreen(Screen::findOrFail($id), false);
                return;
            }
        }
        $this->prepareControls();
    }

    protected function getProcess(array $data = []): Process
    {
        $process = new Process(array_merge([
            'chat' => $this->chat,
            'screen' => $this->screen,
            'character' => $this->character,
        ], $data));
        $process->screenWaiting = $this->waiting;

        return $process;
    }

    protected function screenState(int $screenId = null): ChatScreenState
    {
        $screenId = $screenId ?: $this->screen->getKey();
        return $this->chat->screenStates->where('screen_id', $screenId)->firstOrFail();
    }
}
