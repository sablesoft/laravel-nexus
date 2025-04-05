<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Process;
use App\Logic\Facades\Dsl;
use App\Logic\Facades\EffectRunner;

/**
 * Runtime handler for the `if` effect.
 * Evaluates a boolean expression in the current process context
 * and conditionally executes either the `then` or `else` block.
 *
 * Context:
 * - Registered under the key `"if"` in the EffectHandlerRegistry.
 * - Associated with `IfDefinition` for validation and structure.
 * - Commonly used for conditional branching in DSL scenarios and steps.
 *
 * Behavior:
 * - If the condition evaluates to `true`, executes the `then` effects.
 * - Otherwise, executes the optional `else` effects (if provided).
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

    public function describeLog(Process $process): ?string
    {
        $result = Dsl::evaluate($this->params['condition'], $process->toContext());

        return 'IF "' . $this->params['condition'] . '" → ' . ($result ? 'THEN' : 'ELSE');
    }

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
