<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Process;
use App\Logic\Facades\Dsl;
use App\Logic\Facades\EffectRunner;

/**
 * Runtime handler for the `if` effect.
 * Evaluates a boolean DSL expression and conditionally executes either the `then` or `else` effect blocks.
 * Enables branching logic inside scenarios, steps, and controls.
 *
 * Context:
 * - Resolved by `EffectHandlerRegistry` for the `"if"` key.
 * - Paired with `IfDefinition`, which defines schema and structure.
 * - Uses `Dsl::evaluate(...)` to resolve the condition in the current process context.
 * - Delegates effect execution to `EffectRunner::run(...)`.
 */
class IfHandler implements EffectHandlerContract
{
    /**
     * @param array{
     *     condition: string,
     *     then: array<int, array<string, mixed>>,
     *     else?: array<int, array<string, mixed>>
     * } $params Conditional effect structure
     */
    public function __construct(protected array $params) {}

    /**
     * Execute the appropriate effect block based on the evaluated condition.
     */
    public function execute(Process $process): void
    {
        $condition = $this->params['condition'];
        $context = $process->toContext();

        if (!Dsl::evaluate($condition, $context)) {
            if (!empty($this->params['else'])) {
                EffectRunner::run($this->params['else'], $process);
            }
            return;
        }

        EffectRunner::run($this->params['then'], $process);
    }
}
