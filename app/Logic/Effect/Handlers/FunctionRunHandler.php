<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Effect\Handlers\Traits\Condition;
use App\Logic\Facades\Dsl;
use App\Logic\Facades\EffectRunner;
use App\Logic\Process;
use InvalidArgumentException;
use Symfony\Component\ExpressionLanguage\SyntaxError;

/**
 * Runtime handler for the `function.run` effect.
 * Executes a list of effects either directly (if passed as array), or
 * by resolving a string path to an array stored in the current process context.
 *
 * Context:
 * - Used to dynamically invoke nested logic stored under keys like `handlers.jump`.
 * - Accepts inline arrays or context-based references.
 */
class FunctionRunHandler implements EffectHandlerContract
{
    use Condition;

    protected string $name;

    /**
     * @param array $params
     */
    public function __construct(protected array $params) {}

    public function describeLog(Process $process): ?string
    {
        return "Executing function effects";
    }

    public function execute(Process $process): void
    {
        $this->prepareParams($process);
        if ($this->shouldSkip($process)) {
            return;
        }

        $effects = $process->get($this->name, null, Process::STORAGE_TYPE_FUNCTION);
        if (empty($effects) || !is_array($effects)) {
            throw new InvalidArgumentException("Effect expects a array of function effects.");
        }

        EffectRunner::run($effects, $process);
    }

    protected function prepareParams(Process $process): void
    {
        try {
           $this->name = ValueResolver::resolve($this->params['name'], $process);
        } catch (SyntaxError) {
            $this->name = $this->params['name'];
        }
        if (!$process->has($this->name, Process::STORAGE_TYPE_FUNCTION)) {
            throw new InvalidArgumentException("Function not found: " . $this->name);
        }
    }
}
