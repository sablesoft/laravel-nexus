<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Process;
use App\Models\Character;

class CharacterStateHandler implements EffectHandlerContract
{
    public function __construct(
        protected array $params,
    ) {}

    public function describeLog(Process $process): ?string
    {
        $targets = !empty($this->params['targets']) ?
            implode(', ', $this->params['targets']) :
            $process->character->getKey();
        $keys = implode(', ', array_keys($this->params['values']));
        return "Set character state(s) [{$keys}] for [{$targets}]";
    }

    public function execute(Process $process): void
    {
        $ids = $this->resolveTargetIds($this->params['targets'] ?? null, $process);
        $resolved = [];
        foreach ($this->params['values'] as $key => $expr) {
            $resolved[$key] = ValueResolver::resolve($expr, $process);
        }
        $characters = Character::whereIn('id', $ids)->get();
        foreach ($characters as $character) {
            foreach ($resolved as $key => $value) {
                $character->setState($key, $value);
            }
            $character->save();
        }
    }

    protected function resolveTargetIds(?array $targets, Process $process): array
    {
        if (!$targets) {
            return [$process->character->getKey()];
        }

        return array_filter($targets, fn ($id) => is_numeric($id));
    }
}
