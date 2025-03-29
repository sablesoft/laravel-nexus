<?php

namespace App\Logic\Runners;

use App\Logic\Facades\Dsl;
use App\Logic\Process;
use RuntimeException;
use Throwable;

class SetupRunner
{
    const STRING_PATTERN = '||';

    public function run(?array $config, Process $process): bool
    {
        if (!$config) {
            return true;
        }

        if (isset($config['active'])) {
            if (!$this->active($config['active'], $process)) {
                return false;
            }
        }

        if (!empty($config['rules']) && is_array($config['rules'])) {
            // todo - check config structure more strict
            $this->rules($config['rules'], $process);
        }

        if (!empty($config['data']) && is_array($config['data'])) {
            // todo - check config structure more strict
            $this->data($config['data'], $process);
        }

        foreach ($config['cleanup'] ?? [] as $key) {
            $process->forget($key);
        }

        return true;
    }

    protected function active(array $config, Process $process): bool
    {
        $context = $process->toContext();
        if (!isset($config['condition']) || is_array($config['condition'])) {
            // todo - check structure more strict
            $result = true;
        } else {
            $result = (bool) $this->evaluate($config['active'], $context);
        }

        $key = $result ? 'pass' : 'fail';
        if (isset($config[$key]) && is_array($config[$key])) {
            foreach ($config[$key] as $field => $expr) {
                $process->set($field, $this->evaluate($expr, $context));
            }
        }

        return $result;
    }

    protected function rules(array $rules, Process $process): void
    {
        try {
            validator($process->all(), $rules)->validate();
        } catch (Throwable $e) {
            dd($process, $e);
        }
    }

    protected function data(array $data, Process $process): void
    {
        $pending = $data;

        while (!empty($pending)) {
            $progress = false;
            $context = $process->toContext();
            foreach ($pending as $key => $expr) {
                try {
                    $value = $this->evaluate($expr, $context);
                    $process->set($key, $value);
                    $context[$key] = $value;
                    unset($pending[$key]);
                    $progress = true;
                } catch (Throwable $e) {
                    logger()->warning('[Logic][SetupRunner] Evaluate error', [
                        'error' => $e,
                        'process' => $process->toArray(),
                        'pending' => $pending
                    ]);
                    continue;
                }
            }
            if (!$progress) {
                break;
            }
        }
        if (!empty($pending)) {
            throw new RuntimeException(
                'Unable to resolve some values in `data`: ' . implode(', ', array_keys($pending))
            );
        }
    }


    protected function evaluate(mixed $expr, array $context): mixed
    {
        if (is_array($expr)) {
            $result = [];
            foreach ($expr as $key => $subExpr) {
                $result[$key] = $this->evaluate($subExpr, $context);
            }
            return $result;
        }

        if (is_string($expr)) {
            if (str_starts_with($expr, self::STRING_PATTERN)) {
                $value = ltrim(substr($expr, 2));
                if (str_contains($value, '{{')) {
                    return $this->interpolate($value, $context);
                }

                return $value;
            }

            return Dsl::evaluate($expr, $context);
        }

        return $expr;
    }

    protected function interpolate(string $template, array $context): string
    {
        return preg_replace_callback('/{{\s*(.*?)\s*}}/', function ($matches) use ($context) {
            return Dsl::evaluate($matches[1], $context);
        }, $template);
    }

}
