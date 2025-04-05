<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Exception\ReturnException;
use App\Logic\Process;

/**
 * Runtime handler for the `return` effect.
 * Throws a `ReturnException` that cleanly exits the current logic flow.
 *
 * Context:
 * - Registered under the key `"return"` in the EffectHandlerRegistry.
 * - Controlled by `ReturnDefinition`, which provides an optional `value`.
 * - Used for early exits from DSL logic blocks like steps or scenarios.
 *
 * Behavior:
 * - `true`  → full return from LogicContract (e.g. scenario).
 * - `false` → return only from current node (e.g. step), outer logic continues.
 *
 * Exception is not considered an error — it's intercepted and handled
 * by the effect runner (or node/logic runners) gracefully.
 */
class ReturnHandler implements EffectHandlerContract
{
    public function __construct(protected bool $value = true) {}

    public function describeLog(Process $process): ?string
    {
        return $this->value
            ? 'Return: exiting entire logic flow'
            : 'Return: exiting current node only';
    }

    /**
     * @throws ReturnException
     */
    public function execute(Process $process): void
    {
        throw new ReturnException($this->value);
    }
}
