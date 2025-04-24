<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Act;
use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Process;
use Symfony\Component\ExpressionLanguage\SyntaxError;

/**
 * Runtime handler for the `character.action.case` effect.
 * Store a character-action case in the current process context.
 *
 * Context:
 * - Used to prepare cases with nested logic stored under name like `look-door`.
 */
class ActionCaseHandler implements EffectHandlerContract
{
    protected string $name;
    protected array $case;

    /**
     * @param array $params
     */
    public function __construct(protected array $params) {}

    public function describeLog(Process $process): ?string
    {
        return "Preparing Character Action Case";
    }

    public function execute(Process $process): void
    {
        $this->prepareParams($process);

        $process->set($this->name, $this->case, Process::STORAGE_TYPE_CASE);
    }

    protected function prepareParams(Process $process): void
    {
        try {
            $this->name = ValueResolver::resolve($this->params['name'], $process);
        } catch (SyntaxError) {
            $this->name = $this->params['name'];
        }

        foreach (Act::propertyKeys(true) as $property) {
            $this->case[$property] = isset($this->params[$property]) ?
                ValueResolver::resolve($this->params[$property], $process) : [];
        }
        $this->case['then'] = $this->params['then'];
    }
}
