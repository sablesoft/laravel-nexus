<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Process;
use App\Models\Memory;

/**
 * Runtime handler for the `memory.create` effect.
 * Resolves parameters and creates a new memory record in the database.
 *
 * Context:
 * - Registered under the key `"memory.create"` in the EffectHandlerRegistry.
 * - Validated by `MemoryCreateDefinition`, which defines structure and rules.
 * - Commonly used for narrative tracking, annotations, state snapshots, and chat logs.
 *
 * Behavior:
 * - Evaluates all fields using DSL context.
 * - Defaults `type` to current screen code if not provided.
 * - Persists a record into the `memories` table with chat binding.
 */
class MemoryCreateHandler implements EffectHandlerContract
{
    /**
     * @param array{
     *     type?: string,
     *     data: array<string, mixed>
     * } $params
     */
    public function __construct(protected array $params) {}

    public function describeLog(Process $process): ?string
    {
        $params = ValueResolver::resolve($this->params, $process);

        $type = $params['type'] ?? $process->screen->code();
        $title = $params['data']['title'] ?? null;
        $content = $params['data']['content'] ?? null;

        if ($title) {
            return "Created memory [$type]: $title";
        }

        if ($content) {
            return "Created memory [$type] with content: " . \Str::limit($content, 80);
        }

        return "Created memory [$type]";
    }

    /**
     * Execute the memory creation using resolved data.
     */
    public function execute(Process $process): void
    {
        // Evaluate all values in the context of the current process
        $params = ValueResolver::resolve($this->params, $process);

        // Determine memory type
        $type = $params['type'] ?? $process->screen->code();

        // Prepare and store memory record
        $data = $params['data'];
        $data['type'] = $type;
        $data['chat_id'] = $process->chat->id();

        Memory::create($data);
    }
}
