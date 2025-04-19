<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Effect\Definitions\ChatCompletionDefinition;
use App\Logic\Facades\Dsl;
use App\Logic\Facades\EffectRunner;
use App\Logic\Process;
use App\Logic\ToolCall;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Executes the `chat.completion` effect by sending a chat request to OpenAI
 * and optionally handling tool calls and regular message responses.
 * Resulting `content`, `calls.*`, and `call.arguments` are injected into the process
 * for further use across subsequent logic blocks.
 *
 * Context:
 * - Used by the DSL effect `chat.completion`.
 * - Depends on configuration provided via resolved DSL params (model, messages, etc).
 * - Executes downstream effects (content, calls.*) if provided.
 * - Compiles only request-relevant fields initially (model, messages, etc).
 * - Defers execution of content/calls blocks until OpenAI response is available.
 * - Stores tool call results as stdClass to support Symfony expression language access.
 */
class ChatCompletionHandler implements EffectHandlerContract
{
    use AsyncTrait;

    public function __construct(protected array $params) {}

    public function describeLog(Process $process): ?string
    {
        $model = $this->params['model'] ?? 'unknown';
        $messages = $this->params['messages'] ?? null;
        $tools = $this->params['tools'] ?? null;

        $summary = "OpenAI chat completion with model: {$model}";

        if (is_array($messages)) {
            $summary .= ", messages: " . count($messages);
        }

        if (!empty($tools)) {
            $summary .= ", tools: " . (is_array($tools) ? implode(', ', array_keys($tools)) : $tools);
        }

        return $summary;
    }

    /**
     * Sends chat completion request to OpenAI and handles response:
     * - sets `content` if present;
     * - stores `calls.*` if tool calls are returned;
     * - invokes downstream effects if configured.
     *
     * @throws Throwable on API or execution failure
     */
    public function execute(Process $process): void
    {
        if ($this->isAsync($process, ChatCompletionDefinition::KEY)) {
            return;
        }

        $compiled = ValueResolver::resolve(Arr::except($this->params, ['calls', 'content']), $process);
        $request = $this->buildRequest($compiled);
        $request['model'] = $request['model'] ?? config('openai.gpt_model', 'gpt-4o');
        Dsl::debug('[chat.completion] request', $request, 'effect');

        if ($this->isFake($process)) {
            return;
        }

        try {
            // Cleanup previously injected response data (if re-entered)
            $process->forget(['call', 'content', 'calls']);

            $response = OpenAI::chat()->create($request);
            $choice = $response->choices[0]->message;
            Dsl::debug('[chat.completion] response', [
                'message' => $choice->toArray(),
                'usage' => $response->usage->toArray(),
                'meta' => $response->meta()->toArray()
            ], 'effect');

            // Handle regular content-based response
            $process->set('content', $choice->content);
            if ($content = $this->params['content'] ?? null) {
                    $effects = is_string($content) ?
                        ValueResolver::resolve($content, $process):
                        $content;
                EffectRunner::run($effects, $process);
            }

            // Handle tool function calls (if any)
            if (!empty($choice->toolCalls)) {
                foreach ($choice->toolCalls as $toolCall) {
                    $name = $toolCall->function->name;
                    $arguments = json_decode($toolCall->function->arguments ?? '{}', true);
                    $process->push('calls', new ToolCall($name, $arguments));
                }
                $this->handleCalls($process);
            }
        } catch (Throwable $e) {
            $this->notifyError($e, $process, $request);
            throw $e;
        }
    }

    protected function isFake(Process $process): bool
    {
        if (!config('app.fake.completion')) {
            return false;
        }

        Dsl::debug('[chat.completion] fake content used', [], 'effect');

        $process->set('content', fake(app()->getLocale())->realText());
        if ($content = $this->params['content'] ?? null) {
            $effects = is_string($content) ?
                ValueResolver::resolve($content, $process):
                $content;
            EffectRunner::run($effects, $process);
        }

        return true;
    }

    /**
     * Prepares OpenAI API payload by extracting allowed fields
     * and formatting optional tools block (if defined).
     */
    protected function buildRequest(array $config): array
    {
        return Arr::only($config, [
                'model', 'messages', 'temperature', 'max_tokens', 'top_p',
                'stop', 'presence_penalty', 'frequency_penalty', 'response_format', 'tool_choice',
            ]) + $this->prepareTools($config);
    }

    /**
     * Transforms tool map (name => schema) into OpenAI-compatible tool list.
     */
    protected function prepareTools(array $config): array
    {
        if (empty($config['tools']) || !is_array($config['tools'])) {
            return [];
        }

        $tools = [];
        foreach ($config['tools'] as $name => $tool) {
            $tools[] = [
                'type' => 'function',
                'function' => [
                    'name' => $name,
                    'description' => $tool['description'] ?? '',
                    'parameters' => $tool['parameters'] ?? [],
                    'strict' => $tool['strict'] ?? false
                ],
            ];
        }

        return ['tools' => $tools];
    }

    /**
     * Resolves and executes handlers for all received tool calls.
     * Each tool handler receives `call` arguments in the process.
     */
    protected function handleCalls(Process $process): void
    {
        if (empty($this->params['calls'])) {
            return;
        }
        $compiled = ValueResolver::resolve($this->params['calls'], $process);
        /** @var ToolCall $call */
        foreach ($process->get('calls', []) as $call) {
            $block = $compiled[$call->name()] ?? null;
            if ($block) {
                $process->set('call', $call);
                EffectRunner::run($block, $process);
            } else {
                Log::warning("No handler for tool call: {$call->name()}");
            }
        }
    }

    /**
     * Logs (and later: notifies) runtime or API errors.
     */
    protected function notifyError(Throwable $e, Process $process, array $request): void
    {
        Log::error('[Effect][chat.completion] Error', [
            'error' => [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTrace()
            ],
            'request' => $request,
            'params' => $this->params,
            'process' => $process->pack()
        ]);
    }
}
