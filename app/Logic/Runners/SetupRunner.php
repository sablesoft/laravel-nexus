<?php

namespace App\Logic\Runners;

use App\Logic\Dsl;
use App\Logic\Process;

class SetupRunner
{
    public function __construct(
        protected Dsl $dsl,
    ) {}

    public function run(?array $config, Process $process): void
    {
        if (!$config) return;

        if (!empty($config['active'])) {
            $result = $this->dsl->evaluate($config['active'], $process->toExpressionContext());
            if (!$result) return;
        }

        if (!empty($config['rules'])) {
            validator($process->all(), $config['rules'])->validate();
        }

        if (!empty($config['data'])) {
            foreach ($config['data'] as $key => $expr) {
                $process->set($key, $this->dsl->evaluate($expr, $process->toExpressionContext()));
            }
        }

        foreach ($config['cleanup'] ?? [] as $key) {
            $process->forget($key);
        }
    }
}
