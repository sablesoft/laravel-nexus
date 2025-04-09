<?php

namespace App\Logic\Effect\Handlers;

use App\Models\Screen;
use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Process;
use Illuminate\Support\Collection;

class ScreenStateHandler implements EffectHandlerContract
{
    public function __construct(
        protected string|array $params,
    ) {}

    public function describeLog(Process $process): ?string
    {
        $params = ValueResolver::resolve($this->params, $process);
        $keys = implode(', ', array_keys($params['values'] ?? []));
        $targets = $params['targets'] ?? [];
        $targetInfo = $targets ?
            implode(', ', $targets) :
            $process->screen->code;
        return "Set screen state(s) [{$keys}] on [{$targetInfo}] screen(s)";
    }

    public function execute(Process $process): void
    {
        $params = ValueResolver::resolve($this->params, $process);
        if (!$process->chat->getKey()) {
            throw new \DomainException('Cannot use screen.state effect without chat in context');
        }

        $screenIds = $this->resolveScreenIds($process, $params['targets'] ?? []);

        /** @var Collection $stateMap */
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
        foreach ($params['values'] as $key => $expr) {
            $resolved[$key] = ValueResolver::resolve($expr, $process);
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
    protected function resolveScreenIds(Process $process, array $targets): array
    {
        if (!$targets) {
            return [$process->screen->getKey()];
        }

        return Screen::query()
            ->whereIn('code', $targets)
            ->where('application_id', $process->chat->application_id)
            ->pluck('id')
            ->all();
    }
}
