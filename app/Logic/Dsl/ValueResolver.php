<?php

namespace App\Logic\Dsl;

use App\logic\Facades\Dsl;
use App\Logic\Process;

/**
 * Resolves any expression used in the DSL system into its final runtime value.
 * Supports literals, nested arrays, DSL expressions, and string interpolations.
 * Handles automatic prefix-based detection of static strings to distinguish them
 * from dynamic expressions, providing a unified way to treat values in YAML/JSON.
 *
 * Context:
 * - Used extensively during effect execution and logic evaluation.
 * - Called by handlers to extract real runtime values from user-defined input.
 * - Relies on the `Dsl` facade to interpret dynamic expressions using Symfony ExpressionLanguage.
 *
 * Supported Features:
 * - Literal passthrough (numbers, booleans, arrays, etc.).
 * - DSL evaluation of string expressions (e.g., `user.name`).
 * - String prefix handling (e.g., `>>some static value`).
 * - Mustache-style interpolation within strings (`{{ expr }}`).
 */
class ValueResolver
{
    public const DEFAULT_STRING_PREFIX = '>>';
    public const DEFAULT_RAW_PREFIX = '!';

    /**
     * Get the string prefix used to indicate static string literals.
     *
     * @return string Prefix defined in config or default to '>>'
     */
    protected static function stringPattern(): string
    {
        return config('dsl.string_prefix', self::DEFAULT_STRING_PREFIX);
    }

    /**
     * Resolve a given expression using the provided process context.
     *
     * @param mixed $expr A value, expression, or nested structure
     * @param Process|array $process The current runtime logic context
     * @return mixed Fully resolved runtime value
     */
    public static function resolve(mixed $expr, Process|array $process): mixed
    {
        return static::evaluate($expr, static::context($process));
    }

    public static function resolveWithRaw(string &$key, mixed $expr, Process|array $process): mixed
    {
        // Check if the key starts with one or more raw prefixes
        $isRaw = false;
        $prefix = config('dsl.raw_prefix');
        while (str_starts_with($key, $prefix)) {
            $key = substr($key, strlen($prefix));
            $isRaw = true;
        }

        // If key was raw-marked, return value without compiling
        if ($isRaw) {
            return $expr;
        }

        return static::resolve($expr, $process);
    }

    /**
     * Evaluate an expression recursively using context.
     *
     * @param mixed $expr Raw input value or expression
     * @param array<string, mixed> $context Process context as array
     * @return mixed Evaluated value
     */
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

    /**
     * Perform variable interpolation inside a static string using {{ expr }} syntax.
     *
     * @param string $template String with embedded expressions
     * @param array<string, mixed> $context Process context
     * @return string Interpolated string with evaluated values
     */
    protected static function interpolate(string $template, array $context): string
    {
        return preg_replace_callback('/{{\s*(.*?)\s*}}/', function ($matches) use ($context) {
            return Dsl::evaluate($matches[1], $context);
        }, $template);
    }

    protected static function context(Process|array $process): array
    {
        return is_array($process) ? $process : $process->toContext();
    }
}
