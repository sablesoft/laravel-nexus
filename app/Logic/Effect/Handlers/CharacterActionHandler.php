<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Act;
use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\Adapters\CharacterDslAdapter;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Effect\Definitions\CharacterActionDefinition;
use App\Logic\Effect\Definitions\ChatCompletionDefinition;
use App\Logic\Effect\Handlers\Traits\Async;
use App\Logic\Facades\Dsl;
use App\Logic\Facades\EffectRunner;
use App\Logic\Process;
use App\Logic\ToolCall;
use Symfony\Component\ExpressionLanguage\SyntaxError;
use Symfony\Component\Yaml\Yaml;

class CharacterActionHandler implements EffectHandlerContract
{
    use Async;

    const TOOL_NAME = 'classify';
    const FALLBACK_VERB = 'other';

    protected CharacterDslAdapter $character;
    protected string $ask;
    protected ?string $pipeFlag = null;
    protected string $instruction = '';
    protected ?string $model = null;
    protected array $messages = [];
    protected array $allowed = [];
    protected array $cases = [];
    protected array|null $before = null;
    protected array|null $always = null;
    protected array|null $default = null;

    protected ?string $previousAction = null;

    public function __construct(protected array $params) {}

    public function execute(Process $process): void
    {
        if ($this->isAsync($process, CharacterActionDefinition::KEY)) {
            return;
        }

        $this->prepareParams($process);
        $this->classify($process);

        if ($this->before) {
            EffectRunner::run($this->before, $process);
        }

        /** @var ToolCall $call **/
        foreach ($process->get('calls', []) as $call) {
            if (!$call instanceof ToolCall) {
                throw new \RuntimeException("character.act: Expected tool calls result in 'calls'.");
            }
            if ($this->pipeFlag) {
                $process->forget($this->pipeFlag);
            }
            if ($call->name() === static::TOOL_NAME) {
                $this->handleCall($call, $process);
            }
            if ($this->pipeFlag && empty($process->get($this->pipeFlag))) {
                break;
            }
        }
    }

    protected function classify(Process $process): void
    {
        $actions = $this->character->behaviorsInfo($this->allowed);
        if (!isset($actions[static::FALLBACK_VERB])) {
            $actions[static::FALLBACK_VERB] = [
                'description' => 'Any user action that does not match the predefined list. Fill all other parameters based on context and the intended meaning of each field.',
            ];
        }
        $this->instruction .= "\n" . $this->renderActionListYaml($actions);
        $chatParams = Dsl::prefixed([
            'model' => $this->model,
            'tool_choice' => $this->pipeFlag ? 'auto' : [
                'type' => 'function',
                'function' => [
                    'name' => static::TOOL_NAME
                ],
            ],
            'tools' => [
                static::TOOL_NAME => $this->toolSchema($actions),
            ],
            'messages' => array_merge($this->messages, [
                ['role' => 'system', 'content' => $this->instruction],
                ['role' => 'user', 'content' => "Classify: ". $this->ask]
            ])
        ]);

        EffectRunner::run([
            [ChatCompletionDefinition::KEY => $chatParams]
        ], $process);
    }

    protected function renderActionListYaml(array $actions): string
    {
        // Преобразуем действия в корректный YAML-массив
        $export = [
            'available_actions' => [],
        ];

        $properties = Act::propertyKeys();

        foreach ($actions as $verb => $info) {
            $item = [
                'do' => $verb,
                'description' => $info['description'] ?? 'no description',
            ];

            foreach ($properties as $param) {
                if (isset($info[$param]) && is_string($info[$param])) {
                    $item[$param] = $info[$param];
                }
            }

            $export['available_actions'][] = $item;
        }

        // Генерируем YAML с отступами = 2, без inline
        return "---\n" . Yaml::dump($export, 4, 2, Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK);
    }


    protected function toolSchema(array $actions): array
    {
        $propertiesSchema = [
            'action' => [
                'type' => 'string',
                'description' => 'Plain English description of this single user action, to help constrain the generation'
            ],
            'do' => [
                'type' => 'string',
                'enum' => array_keys($actions),
                'description' => 'Name of the action to perform (must match predefined list)'
            ]
        ];
        foreach (Act::properties() as $property => $description) {
            $propertiesSchema[$property] = [
                'type' => 'array',
                'items' => [
                    'type' => 'string',
                ],
                'description' => $description
            ];
        }

        return [
            'description' => 'Classify player action. Only English words allowed.',
            'parameters' => [
                'type' => 'object',
                'properties' => $propertiesSchema,
                'required' => array_merge(['action'], Act::propertyKeys(true)),
                'additionalProperties' => false
            ],
            'strict' => true
        ];
    }

    protected function handleCall(ToolCall $call, Process $process): void
    {
        $act = new Act($call->arguments);
        $process->set('act', $act);
        if ($this->pipeFlag) {
            if ($this->previousAction) {
                $instruction = view('instructions.bound-act', [
                    'previousAction' => $this->previousAction
                ])->render();
                $process->push('messages', [
                    'role' => 'system',
                    'content' => $instruction
                ]);
            }
            $this->previousAction = $act->action;
        }
        if ($this->always) {
            $this->runEffects($this->always, $process, $act->action);
        }
        foreach ($this->cases as $case) {
            $filter = \Arr::only($case, Act::propertyKeys(true));
            $filter = ValueResolver::resolve($filter, $process->toContext());
            if (!isset($filter['do'])) {
                continue;
            }
            if (!$match = $act->match($filter)) {
                continue;
            }
            $process->set('match', $match);
            $this->runEffects($case['then'], $process, $act->action);
            return;
        }

        if ($this->default) {
            $this->runEffects($this->default, $process, $act->action);
        }
    }

    protected function runEffects(array $effects, Process $process, string $action): void
    {
        if ($this->pipeFlag) {
            $process->set('_ask', $process->get('ask'));
            $process->set('ask', $action);
        }

        EffectRunner::run($effects, $process);

        if ($this->pipeFlag) {
            $process->set('ask', $process->get('_ask'));
        }
    }

    /**
     * todo - write describe log
     */
    public function describeLog(Process $process): ?string
    {
        return 'Character Act Run';
    }

    protected function prepareParams(Process $process): void
    {
        $context = $process->toContext();
        $this->preparePipeFlag($context);
        $this->prepareInstruction($context);
        $this->prepareAsk($context);
        $this->prepareCharacter($context);
        foreach (['messages', 'allowed', 'model'] as $param) {
            if (!empty($this->params[$param])) {
                $this->$param = ValueResolver::resolve($this->params[$param], $context);
            }
        }
        foreach (['before', 'always', 'cases', 'default'] as $param) {
            if (!empty($this->params[$param])) {
                $value = $this->params[$param];
                $this->$param = is_array($value) ? $value : ValueResolver::resolve($value, $context);
            }
        }
    }

    protected function preparePipeFlag(array $context): void
    {
        $flag = $this->params['pipeFlag'] ?? null;
        if ($flag) {
            try {
                $flag = ValueResolver::resolve($flag, $context);
            } catch (SyntaxError) {}
        }
        $this->pipeFlag = $flag ?: null;
    }

    protected function prepareInstruction(array $context): void
    {
        $params = [
            'toolName' => static::TOOL_NAME,
            'fallbackVerb' => static::FALLBACK_VERB,
            'pipeFlag' => $this->pipeFlag,
            'properties' => implode(', ',Act::propertyKeys())
        ];
        if (empty($this->params['instruction'])) {
            $this->instruction = view('instructions.classify-act', $params)->render();
        } else {
            $this->instruction = ValueResolver::resolve($this->params['instruction'], $context);
            try {
                // try to compile second time if note used for example:
                $this->instruction = ValueResolver::resolve(Dsl::prefixed($this->instruction), $context);
            } catch (\Throwable) {}
        }
    }

    protected function prepareAsk(array $context): void
    {
        $ask = isset($this->params['ask']) ?
            ValueResolver::resolve($this->params['ask'], $context):
            ($context['ask'] ?? null);
        if (empty($ask) || !is_string($ask)) {
            throw new \InvalidArgumentException("character.act: invalid or missing ask.");
        }
        $this->ask = $ask;
    }

    protected function prepareCharacter(array $context): void
    {
        $character = $this->params['character'] ?? $context['character'] ?? null;
        if (is_string($character)) {
            $this->character = CharacterDslAdapter::fromCode(ValueResolver::resolve($character, $context));
        } elseif ($character instanceof CharacterDslAdapter) {
            $this->character = $character;
        } else {
            throw new \InvalidArgumentException("character.act: invalid or missing character.");
        }
        if (!$this->character->id()) {
            throw new \InvalidArgumentException("character.act: invalid or missing character.");
        }
    }
}
