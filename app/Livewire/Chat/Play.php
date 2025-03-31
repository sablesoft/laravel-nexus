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

    /** The current chat instance */
    #[Locked]
    public Chat $chat;

    #[Locked]
    public int $memberId;

    #[Locked]
    public Application $application;

    /** The currently active screen (defines transfers, controls, inputs) */
    #[Locked]
    public Screen $screen;

    /** Stack of screen IDs visited by the user (used for navigation) */
    #[Locked]
    public array $screenHistory = [];

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

    #[On('refresh.screen')]
    public function refresh(): void
    {
        $this->chat->load('memories.member');
        $this->prepareMemories();
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
        $this->memberId = $this->chat->takenSeats->where('user_id', auth()->id())->first()->id;
        $this->initMembers();
        $this->initScreen($this->application->initScreen);
    }

    protected function initMembers(): void
    {
        $this->offlineMembers = $this->chat->takenSeats->filter(
            fn($member) => !in_array($member->user_id, $this->userIds)
        );
        $this->onlineMembers = $this->chat->takenSeats->filter(
            fn($member) => in_array($member->user_id, $this->userIds)
        );
    }

    protected function initScreen(Screen $screen, bool $withHistory = true): void
    {
        if ($withHistory) {
            $this->screenHistory[] = $screen->id;
        }
        $this->screen = $screen;
        $this->prepareControl();
        $this->prepareMemories();
    }

    protected function prepareControl(): void
    {
        $this->transfers = collect($this->getTransfers())->keyBy('id')->toArray();
        $this->actions = collect($this->getControls(ControlType::Action->value))->keyBy('id')->toArray();
        $this->inputs = collect($this->getControls(ControlType::Input->value))->keyBy('id')->toArray();
        $this->activeInput = reset($this->inputs) ?: null;
    }

    protected function prepareMemories(): void
    {
        $this->memories = collect($this->getMemories())->keyBy('id')->toArray();
    }

    protected function getTransfers(): array
    {
        return $this->screen->transfers->map(fn(Transfer $transfer) => [
            'id' => $transfer->id,
            'screen_to_id' => $transfer->screen_to_id,
            'title' => $transfer->title,
            'tooltip' => $transfer->tooltip,
        ])->toArray();
    }

    protected function getControls(string $type): array
    {
        return $this->screen->controls->where('type', $type)
            ->map(fn(Control $control) => [
                'id' => $control->id,
                'title' => $control->title,
                'tooltip' => $control->tooltip,
            ])->toArray();
    }

    protected function getMemories(): array
    {
        $query = Dsl::apply(Memory::query(), $this->screen->query, $this->getProcess()->toContext());
        return $query->with('member')->where('chat_id', $this->chat->id)->get()
            ->map(fn(Memory $memory) => [
                'id' => $memory->id,
                'member_id' => $memory->member_id,
                'user_id' => $memory->member?->user_id,
                'mask_name' => $memory->member?->maskName,
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
    public function transfer(int $screenId): void
    {
        $transfer = $this->getTransfer($screenId);
        NodeRunner::run($transfer, $this->getProcess());
        // todo - remove after completing effects feature:
        $this->initScreen($transfer->screenTo);
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

    public function render(): mixed
    {
        return view('livewire.chat.play')
            ->title('Chat Play: ' . $this->chat->title);
    }

    protected function handleHere(): void
    {
        $this->initMembers();

        $message = $this->getMember()->maskName . ' is playing "' . $this->chat->title . '"';
        $link = route('chats.play', ['id' => $this->chat->id]);
        /** @var Member $member */
        foreach ($this->offlineMembers as $member) {
            $member->user->notifyNow(new ChatPlaying($message, $link));
        }
    }

    protected function handleJoining(int $id): void
    {
        $this->initMembers();
    }

    protected function handleLeaving(int $id): void
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
            if ($member->id !== $this->memberId) {
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

    protected function getMember(?int $memberId = null): Member
    {
        $memberId = $memberId ?: $this->memberId;
        return $this->chat->takenSeats->where('id', $memberId)->firstOrFail();
    }

    protected function getProcess(array $data = []): Process
    {
        return new Process(array_merge([
            'chat' => $this->chat,
            'screen' => $this->screen,
            'member' => $this->getMember(),
        ], $data));
    }
}
