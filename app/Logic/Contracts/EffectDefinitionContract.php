<?php

namespace App\Logic\Contracts;

/**
 * Describes the structure, schema, and behavior of a specific DSL effect.
 * Used for validation, autocompletion, and inline documentation in the editor.
 * Also supports nested effect blocks for control-flow constructs like `if`, `switch`, etc.
 *
 * Each definition must declare a unique `KEY` constant, which is used throughout
 * the codebase to consistently identify this effect type. It should match the DSL key
 * returned from `key()`, and be used when registering handlers, definitions, and other logic.
 *
 * Context:
 * - Registered via the `EffectDefinitionRegistry` at system boot.
 * - Used by `EffectValidator` for static and recursive validation of effect structures.
 * - Powers the Codemirror-based DSL editor for live hints, documentation, and examples.
 */
interface EffectDefinitionContract
{
    public const KEY = '';

    /**
     * Returns the unique DSL key used to invoke this effect.
     * Example: "set", "unset", "validate", etc.
     *
     * This must match the static `KEY` constant of the implementing class.
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
     * @return array<string, mixed>
     */
    public static function describe(): array;

    /**
     * Returns Laravel-style validation rules for this effect's parameters.
     *
     * These rules are applied during compile-time validation, before execution.
     * This allows for early feedback in the editor and safe static analysis.
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
     * If the effect does not support nesting, it should return an empty array.
     *
     * @param array<string, mixed> $params The effect payload to inspect
     * @return array<string, array<int, array<string, mixed>>> Nested effect blocks by slot
     */
    public static function nestedEffects(array $params): array;
}
