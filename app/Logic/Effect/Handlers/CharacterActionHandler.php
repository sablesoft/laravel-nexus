<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Act;
use App\Logic\Dsl\Adapters\CharacterDslAdapter;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Effect\Definitions\CharacterActionDefinition;
use App\Logic\Effect\Definitions\ChatCompletionDefinition;
use App\Logic\Facades\Dsl;
use App\Logic\Facades\EffectRunner;
use App\Logic\Process;
use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\ToolCall;
use Symfony\Component\Yaml\Yaml;

class CharacterActionHandler implements EffectHandlerContract
{
    use AsyncTrait;

    const TOOL_NAME = 'classification';
    const FALLBACK_VERB = 'other';

    protected CharacterDslAdapter $character;
    protected string $ask;
    protected ?string $model = null;
    protected array $messages = [];
    protected array $allowed = [];
    protected array $cases = [];
    protected array|null $always = null;
    protected array|null $default = null;

    public function __construct(protected array $params) {}

    public function execute(Process $process): void
    {
        if ($this->isAsync($process, CharacterActionDefinition::KEY)) {
            return;
        }

        $this->prepareParams($process);
        $this->classification($process);

        /** @var ToolCall $call **/
        foreach ($process->get('calls', []) as $call) {
            if (!$call instanceof ToolCall) {
                throw new \RuntimeException("character.act: Expected tool calls result in 'calls'.");
            }
            if ($call->name() === static::TOOL_NAME) {
                $this->handleCall($call, $process);
            }
        }
    }

    protected function classification(Process $process): void
    {
        $actions = $this->character->behaviorsInfo($this->allowed);
        if (!isset($actions[static::FALLBACK_VERB])) {
            $actions[static::FALLBACK_VERB] = [
                'description' => 'Any user action that does not match the predefined list. Fill all other parameters based on context and the intended meaning of each field.',
            ];
        }
        $instruction = view('instructions.classify-act', [
            'toolName' => static::TOOL_NAME,
            'fallbackVerb' => static::FALLBACK_VERB
        ])->render();
        $instruction .= "\n" . $this->renderActionListYaml($actions);
        $chatParams = Dsl::prefixed([
            'model' => $this->model,
            'tool_choice' => [
                'type' => 'function',
                'function' => [
                    'name' => static::TOOL_NAME
                ],
            ],
            'tools' => [
                static::TOOL_NAME => $this->toolSchema($actions),
            ],
            'messages' => array_merge($this->messages, [
                ['role' => 'system', 'content' => $instruction],
                ['role' => 'user', 'content' => $this->ask]
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
            'description' => 'Classify player action',
            'parameters' => [
                'type' => 'object',
                'properties' => $propertiesSchema,
                'required' => Act::propertyKeys(true),
                'additionalProperties' => false
            ],
            'strict' => true
        ];
    }

    protected function handleCall(ToolCall $call, Process $process): void
    {
        $act = new Act($call->arguments);
        $process->set('act', $act);
        if ($this->always) {
            EffectRunner::run($this->always, $process);
        }
        foreach ($this->cases as $case) {
            if (!isset($case['do']) || !$act->match($case)) {
                continue;
            }
            EffectRunner::run($case['then'], $process);
            return;
        }

        if ($this->default) {
            EffectRunner::run($this->default, $process);
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
        $this->prepareAsk($context);
        $this->prepareCharacter($context);
        foreach (['messages', 'allowed', 'model'] as $param) {
            if (!empty($this->params[$param])) {
                $this->$param = ValueResolver::resolve($this->params[$param], $context);
            }
        }
        foreach (['always', 'cases', 'default'] as $param) {
            if (!empty($this->params[$param])) {
                $this->$param = $this->params[$param];
            }
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
