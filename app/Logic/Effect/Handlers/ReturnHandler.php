<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Exception\ReturnException;
use App\Logic\Process;

/**
 * Runtime handler for the `return` effect.
 * When executed, it throws a `ReturnException`, which interrupts logic execution.
 * The exception carries a boolean flag that distinguishes between full and partial return:
 * - `true` (default): full return from the LogicContract (e.g., scenario).
 * - `false`: return from the current node (e.g., step), outer logic continues.
 *
 * This mechanism enables conditional exits and early termination of logic flows.
 * It’s often used inside `if` blocks, validation checks, or branching logic.
 *
 * Context:
 * - Used by `EffectRunner`, `LogicRunner`, and `NodeRunner` to break flow cleanly.
 * - Exception is caught and handled by the caller (not considered an error).
 */
class ReturnHandler implements EffectHandlerContract
{
    public function __construct(protected bool $value = true) {}

    /**
     * @throws ReturnException
     */
    public function execute(Process $process): void
    {
        throw new ReturnException($this->value);
    }
}
