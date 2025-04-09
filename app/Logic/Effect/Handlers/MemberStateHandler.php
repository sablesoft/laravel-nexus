<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Process;
use App\Models\Member;

class MemberStateHandler implements EffectHandlerContract
{
    public function __construct(
        protected array $values,
        protected ?array $targets = null,
    ) {}

    public function describeLog(Process $process): ?string
    {
        $targets = !empty($this->targets) ?
            implode(', ', $this->targets) :
            $process->member->getKey();
        $keys = implode(', ', array_keys($this->values));
        return "Set member state(s) [{$keys}] for [{$targets}]";
    }

    public function execute(Process $process): void
    {
        $ids = $this->resolveTargetIds($this->targets, $process);
        $resolved = [];
        foreach ($this->values as $key => $expr) {
            $resolved[$key] = ValueResolver::resolve($expr, $process);
        }
        $members = Member::whereIn('id', $ids)->get();
        foreach ($members as $member) {
            foreach ($resolved as $key => $value) {
                $member->setState($key, $value);
            }
            $member->save();
        }
    }

    protected function resolveTargetIds(?array $targets, Process $process): array
    {
        if (!$targets) {
            return [$process->member->getKey()];
        }

        return array_filter($targets, fn ($id) => is_numeric($id));
    }
}
