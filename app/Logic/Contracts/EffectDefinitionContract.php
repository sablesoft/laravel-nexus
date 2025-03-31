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
     * - 'type':       One of "map", "list", or "scalar" — defines the top-level format.
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
}
