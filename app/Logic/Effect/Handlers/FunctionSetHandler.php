<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Effect\Handlers\Traits\Condition;
use App\Logic\Facades\Dsl;
use App\Logic\Process;
use Symfony\Component\ExpressionLanguage\SyntaxError;

/**
 * Runtime handler for the `function.set` effect.
 * Store a list of effects in the current process context as function with name.
 *
 * Context:
 * - Used to prepare custom function with nested logic stored under name like `character_jump`.
 */
class FunctionSetHandler implements EffectHandlerContract
{
    use Condition;

    protected ?string $name = null;
    protected array $effects = [];

    /**
     * @param array $params
     */
    public function __construct(protected array $params) {}

    public function describeLog(Process $process): ?string
    {
        return "Preparing function effects";
    }

    public function execute(Process $process): void
    {
        $this->prepareParams($process);
        if ($this->shouldSkip($process)) {
            return;
        }

        $process->set($this->name, $this->effects, Process::STORAGE_TYPE_FUNCTION);
    }

    protected function prepareParams(Process $process): void
    {
        try {
           $this->name = ValueResolver::resolve($this->params['name'], $process);
        } catch (SyntaxError) {
            $this->name = $this->params['name'];
        }
        $this->effects = $this->params['effects'];
    }
}
