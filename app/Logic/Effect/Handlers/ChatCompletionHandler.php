<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Facades\EffectRunner;
use App\Logic\Process;
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
 * - All API results are retained in the process for further usage.
 */
class ChatCompletionHandler implements EffectHandlerContract
{
    public function __construct(protected array $params) {}

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
        $config = ValueResolver::resolve($this->params, $process);
        $request = $this->buildRequest($config);

        try {
            // Cleanup previously injected response data (if re-entered)
            $process->forget(['call', 'content', 'calls']);

            $response = OpenAI::chat()->create($request);
            $choice = $response->choices[0]->message;

            // Handle regular content-based response
            if (!empty($choice->content)) {
                $process->set('content', $choice->content);
                $effects = $config['content'] ?? null;
                if ($effects) {
                    EffectRunner::run($effects, $process);
                }
            }

            // Handle tool function calls (if any)
            if (isset($choice->toolCalls)) {
                foreach ($choice->toolCalls as $call) {
                    $process->push('calls', [
                        'name' => $call->function->name,
                        'arguments' => json_decode($call->function->arguments ?? '{}', true)
                    ]);
                }
                $this->handleCalls($config, $process);
            }
        } catch (Throwable $e) {
            $this->notifyError($e, $process, $config);
            throw $e;
        }
    }

    /**
     * Prepares OpenAI API payload by extracting allowed fields
     * and formatting optional tools block (if defined).
     */
    protected function buildRequest(array $config): array
    {
        return Arr::only($config, [
                'model',
                'messages',
                'temperature',
                'max_tokens',
                'top_p',
                'stop',
                'presence_penalty',
                'frequency_penalty',
                'response_format',
                'tool_choice',
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
                ],
            ];
        }

        return ['tools' => $tools];
    }

    /**
     * Resolves and executes handlers for all received tool calls.
     * Each tool handler receives `call` arguments in the process.
     */
    protected function handleCalls(array $config, Process $process): void
    {
        foreach ($process->get('calls') as $call) {
            $block = $config['calls'][$call['name']] ?? null;
            if ($block) {
                $process->set('call', $call['arguments']);
                EffectRunner::run($block, $process);
            } else {
                $this->notifyMissedHandler($call, $process);
            }
        }
    }

    /**
     * Called when no handler is defined for a tool call.
     * For now, logs the issue — future version should notify author.
     */
    protected function notifyMissedHandler(array $call, Process $process): void
    {
        Log::warning("No handler defined for tool in chat.completion effect.", [
            'call' => $call,
            'process' => $process->pack()
        ]);
    }

    /**
     * Logs (and later: notifies) runtime or API errors.
     */
    protected function notifyError(Throwable $e, Process $process, array $payload): void
    {
        Log::error('[Effect][chat.completion] Error', [
            'error' => [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTrace()
            ],
            'payload' => $payload,
            'process' => $process->pack()
        ]);
    }
}
