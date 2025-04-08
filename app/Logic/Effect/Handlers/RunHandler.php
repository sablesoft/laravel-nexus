<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Facades\EffectRunner;
use App\Logic\Facades\Dsl;
use App\Logic\Process;
use InvalidArgumentException;

/**
 * Runtime handler for the `run` effect.
 * Executes a list of effects either directly (if passed as array), or
 * by resolving a string path to an array stored in the current process context.
 *
 * Context:
 * - Used to dynamically invoke nested logic stored under keys like `handlers.jump`.
 * - Accepts inline arrays or context-based references.
 */
class RunHandler implements EffectHandlerContract
{
    /**
     * @param string|array $input A path to resolve or a direct effects array
     */
    public function __construct(protected string|array $input) {}

    public function describeLog(Process $process): ?string
    {
        return is_string($this->input)
            ? "Executing effects from context path: `{$this->input}`"
            : "Executing inline effects block";
    }

    public function execute(Process $process): void
    {
        $effects = is_string($this->input)
            ? Dsl::evaluate($this->input, $process->toContext())
            : $this->input;

        if (!is_array($effects)) {
            throw new InvalidArgumentException("Effect `run` expects a resolved array of effects.");
        }

        EffectRunner::run($effects, $process);
    }
}
