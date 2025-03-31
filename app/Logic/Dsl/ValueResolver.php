<?php

namespace App\Logic\Dsl;

use App\logic\Facades\Dsl;
use App\Logic\Process;

class ValueResolver
{
    public const DEFAULT_STRING_PREFIX = '>>';

    protected static function stringPattern(): string
    {
        return config('dsl.string_prefix', self::DEFAULT_STRING_PREFIX);
    }

    public static function resolve(mixed $expr, Process $process): mixed
    {
        return static::evaluate($expr, $process->toContext());
    }

    protected static function evaluate(mixed $expr, array $context): mixed
    {
        if (is_array($expr)) {
            $result = [];
            foreach ($expr as $key => $subExpr) {
                $result[$key] = static::evaluate($subExpr, $context);
            }
            return $result;
        }

        if (is_string($expr)) {
            $pattern = static::stringPattern();

            if (str_starts_with($expr, $pattern)) {
                $value = ltrim(substr($expr, strlen($pattern)));
                return str_contains($value, '{{')
                    ? static::interpolate($value, $context)
                    : $value;
            }

            return Dsl::evaluate($expr, $context);
        }

        return $expr;
    }

    protected static function interpolate(string $template, array $context): string
    {
        return preg_replace_callback('/{{\s*(.*?)\s*}}/', function ($matches) use ($context) {
            return Dsl::evaluate($matches[1], $context);
        }, $template);
    }
}
