<?php

namespace App\Logic\Contracts;

interface EffectDefinitionContract
{
    public const KEY = '';

    /**
     * Returns the unique DSL key used to invoke this effect.
     * Example: "set", "unset", "validate", etc.
     */
    public static function key(): string;

    /**
     * Returns a structured description of the effect's schema and purpose.
     *
     * This metadata is used for:
     * - documentation and tooltips in the editor,
     * - autocompletion and input hints,
     * - compile-time validation of effect structure.
     *
     * Convention for returned array:
     * - 'title':      Short human-readable label for the effect.
     * - 'description':Optional detailed explanation of what the effect does.
     * - 'fields':     Schema for the expected fields (when 'type' is "map").
     *                 Use '*' to define wildcard entries.
     * - 'examples':   One or more example usages (YAML-parsed array form).
     *
     * Example:
     * return [
     *     'type' => 'map',
     *     'title' => 'Set Variables',
     *     'description' => 'Assigns one or more variables to the process context.',
     *     'fields' => [
     *         '*' => ['type' => 'expression', 'description' => 'Value to assign'],
     *     ],
     *     'examples' => [
     *         ['set' => ['foo' => 42, 'bar' => 'user.name']],
     *     ],
     * ];
     *
     * @return array<string, mixed>
     */
    public static function describe(): array;

    /**
     * Returns Laravel-style validation rules for this effect's parameters.
     *
     * These rules are applied during compile-time validation, before execution.
     * This allows for early feedback in the editor and safe static analysis.
     *
     * Example:
     * return [
     *     'type' => 'nullable|string',
     *     'data' => 'required|array',
     *     'data.content' => 'required|string',
     * ];
     *
     * @return array<string, string>
     */
    public static function rules(): array;

    /**
     * Returns nested effect blocks inside this effect, if any.
     *
     * This is used by the centralized validator to support recursive validation
     * of control-flow structures like "if", "switch", or loops.
     *
     * The result is a map of named slots (e.g. "then", "else") to arrays of nested effects.
     *
     * If the effect does not support nesting, it should return an empty array.
     *
     * Example:
     * return [
     *     'then' => $params['then'] ?? [],
     *     'else' => $params['else'] ?? [],
     * ];
     *
     * @param array<string, mixed> $params The effect payload to inspect
     * @return array<string, array<int, array<string, mixed>>> Nested effect blocks by slot
     */
    public static function nestedEffects(array $params): array;
}
