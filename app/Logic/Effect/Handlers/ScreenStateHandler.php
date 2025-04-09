<?php

namespace App\Logic\Effect\Handlers;

use App\Models\Screen;
use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Process;

class ScreenStateHandler implements EffectHandlerContract
{
    public function __construct(
        protected array $values,
        protected ?array $targets = null
    ) {}

    public function describeLog(Process $process): ?string
    {
        $keys = implode(', ', array_keys($this->values));
        $targetInfo = $this->targets ? implode(', ', $this->targets) : 'current';
        return "Set screen state(s) [{$keys}] on [{$targetInfo}] screen(s)";
    }

    public function execute(Process $process): void
    {
        if (!$process->chat->getKey()) {
            throw new \DomainException('Cannot use screen.state effect without chat in context');
        }

        $screenIds = $this->resolveScreenIds($process);

        /** @var \Illuminate\Support\Collection $stateMap */
        $stateMap = $process->chat
            ->screenStates()
            ->whereIn('screen_id', $screenIds)
            ->get()
            ->keyBy('screen_id');

        foreach ($screenIds as $screenId) {
            if (!$stateMap->has($screenId)) {
                throw new \RuntimeException("Screen state not found for screen ID [{$screenId}] in chat [{$process->chat->id}]");
            }
        }

        $resolved = [];
        foreach ($this->values as $key => $expr) {
            $resolved[$key] = ValueResolver::resolve($key, $expr);
        }

        foreach ($stateMap as $screenState) {
            foreach ($resolved as $key => $value) {
                $screenState->setState($key, $value);
            }

            $screenState->save();
        }
    }

    /**
     * @return array<int> screen IDs
     */
    protected function resolveScreenIds(Process $process): array
    {
        if (!$this->targets) {
            return [$process->screen->getKey()];
        }

        return Screen::query()
            ->whereIn('code', $this->targets)
            ->where('application_id', $process->chat->application_id)
            ->pluck('id')
            ->all();
    }
}
