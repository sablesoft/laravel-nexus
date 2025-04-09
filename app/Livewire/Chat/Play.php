<?php

namespace App\Livewire\Chat;

use App\Livewire\PresenceTrait;
use App\Logic\Facades\Dsl;
use App\Logic\Facades\NodeRunner;
use App\Logic\Process;
use App\Models\Application;
use App\Models\Chat;
use App\Models\Control;
use App\Models\Enums\ChatStatus;
use App\Models\Enums\ControlType;
use App\Models\Member;
use App\Models\Memory;
use App\Models\Screen;
use App\Models\Transfer;
use App\Notifications\ChatPlaying;
use App\Notifications\ScreenUpdated;
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

    #[Locked]
    public string $channelsPrefix = self::CHANNELS_PREFIX;

    /** The current chat instance */
    #[Locked]
    public Chat $chat;

    #[Locked]
    public Member $member;

    #[Locked]
    public Application $application;

    /** The currently active screen (defines transfers, controls, inputs) */
    #[Locked]
    public Screen $screen;

    /** Stack of screen IDs visited by the user (used for navigation) */
    #[Locked]
    public array $screenHistory = [];

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

    /** List of online members (calculated via PresenceTrait) */
    #[Locked]
    public Collection $onlineMembers;

    /** List of offline members (calculated via PresenceTrait) */
    #[Locked]
    public Collection $offlineMembers;

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
            'members.mask',
            'memories.member'
        ])->findOrFail($id);
        if (!$this->canPlay()) {
            $this->redirectRoute('chats.view', ['id' => $id], true, true);
        }
        $this->application = $this->chat->application;
        $this->member = $this->chat->takenSeats->where('user_id', auth()->id())->firstOrFail();
        $this->initMembers();
        $this->initScreen($this->member->screen);
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
        $this->chat->load('memories.member');
        $this->prepareMemories();
        $this->prepareControls();
    }

    protected function initMembers(): void
    {
        $this->offlineMembers = $this->chat->takenSeats->filter(
            fn($member) => !in_array($member->user_id, $this->userIds[$this->chatChannel()] ?? [])
        );
        $this->onlineMembers = $this->chat->takenSeats->filter(
            fn($member) => in_array($member->user_id,$this->userIds[$this->chatChannel()] ?? [])
        );
    }

    protected function initScreen(Screen $screen, bool $withHistory = true): void
    {
        if ($withHistory) {
            $this->screenHistory[] = $screen->id;
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
        return $query->with('author')->where('chat_id', $this->chat->id)->get()
            ->map(fn(Memory $memory) => [
                'id' => $memory->id,
                'author_id' => $memory->author_id,
                'member_id' => $memory->member_id,
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
        NodeRunner::run($transfer, $this->getProcess());
        // todo - remove after completing transfer effect:
        $this->member->update(['screen_id' => $transfer->screen_to_id]);
        $fromChannel = $this->screenChannel();
        $this->initScreen($transfer->screenTo);
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
        $process = NodeRunner::run($control, $this->getProcess([
            'ask' => $this->ask
        ]));
        $this->ask = '';

        // todo - remove after completing effects feature:
        if ($process->get('$refresh', false)) {
            $this->refresh();
        }
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
        NodeRunner::run($control, $this->getProcess());
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
        $this->initMembers();

        $message = $this->member->maskName . ' is playing "' . $this->chat->title . '"';
        $link = route('chats.play', ['id' => $this->chat->id]);
        /** @var Member $member */
        foreach ($this->offlineMembers as $member) {
            $member->user->notifyNow(new ChatPlaying($message, $link));
        }
    }

    protected function handleJoining(string $channel, int $id): void
    {
        $this->initMembers();
    }

    protected function handleLeaving(string $channel, int $id): void
    {
        $this->initMembers();
    }

    public function close(): void
    {
        $this->redirectRoute('chats.view', ['id' => $this->chat->id], true, true);
    }

    protected function createMemory(string $type, string $content, ?int $memberId = null): void
    {
        Memory::create([
            'chat_id' => $this->chat->id,
            'member_id' => $memberId,
            'content' => $content,
            'type' => $type
        ]);
        /** @var Member $member */
        foreach ($this->onlineMembers as $member) {
            if ($member->id !== $this->member->id) {
                $member->user->notifyNow(new ScreenUpdated());
            }
        }

        $this->refresh();
    }

    protected function canPlay(): bool
    {
        return $this->chat->status === ChatStatus::Started &&
            !!$this->chat->members->where('user_id', auth()->id())
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

    protected function getProcess(array $data = []): Process
    {
        return new Process(array_merge([
            'chat' => $this->chat,
            'screen' => $this->screen,
            'member' => $this->member,
        ], $data));
    }
}
