<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Effect\Definitions\ChatCompletionDefinition;
use App\Logic\Effect\Definitions\MemoryCardDefinition;
use App\Logic\Effect\Definitions\MemoryCreateDefinition;
use App\Logic\Effect\Handlers\Traits\Async;
use App\Logic\Facades\Dsl;
use App\Logic\Facades\EffectRunner;
use App\Logic\Process;

class MemoryCardHandler implements EffectHandlerContract
{
    use Async;

    protected ?string $model = null;
    protected string $type = 'card';
    protected string $code;
    protected string $title;
    protected string $prompt;

    public function __construct(protected array $params) {}

    public function execute(Process $process): void
    {
        if ($this->isAsync($process, MemoryCardDefinition::KEY)) {
            return;
        }

        $this->prepareParams($process);
        $this->generate($process);
    }

    protected function prepareParams(Process $process): void
    {
        $context = $process->toContext();
        $this->type = !empty($this->params['type']) ?
            ValueResolver::resolve($this->params['type'], $context) :
            'card';
        $this->code = ValueResolver::resolve($this->params['code'], $context);
        $this->title = ValueResolver::resolve($this->params['title'], $context);
        $context['task'] = ValueResolver::resolve($this->params['task'], $context);
        $this->prompt = ValueResolver::resolve($this->params['layout'], $context);
        $this->model = empty($this->params['model']) ? null :
            ValueResolver::resolve($this->params['model'], $context);
    }

    protected function generate(Process $process): void
    {
        EffectRunner::run([
            [ChatCompletionDefinition::KEY => Dsl::prefixed([
                'model' => $this->model,
                'async' => false,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $this->prompt,
                    ]
                ]
            ])],
            [MemoryCreateDefinition::KEY => [
                'title' => Dsl::prefixed($this->title),
                'type' => Dsl::prefixed($this->type),
                'content' => 'content',
                'meta' => Dsl::prefixed([
                    $this->type => $this->code,
                    'tags' => [
                        $this->type,
                        'card'
                    ]
                ])
            ]]
        ], $process);
    }

    public function describeLog(Process $process): ?string
    {
        return 'Generate Memory Card';
    }
}
