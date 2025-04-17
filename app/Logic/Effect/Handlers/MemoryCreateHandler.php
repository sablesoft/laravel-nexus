<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Facades\Dsl;
use App\Logic\Process;
use App\Models\Memory;
use Illuminate\Support\Arr;

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
    public function __construct(protected string|array $data) {}

    public function describeLog(Process $process): ?string
    {
        $params = ValueResolver::resolve($this->data, $process);

        $type = $params['type'] ?? $process->screen->code;
        $title = $params['title'] ?? null;
        $content = $params['content'] ?? null;

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
        $params = ValueResolver::resolve($this->data, $process);
        $params = Arr::only($params, [
            'type', 'title', 'content', 'author_id',
            'character_id', 'image_id', 'meta'
        ]);

        // Determine memory type
        $params['type'] = $params['type'] ?? $process->screen->code;

        // Prepare and store memory record
        $params['chat_id'] = $process->chat->getKey();

        Memory::create($params);

        if ($params['type'] === 'debug') {
            Dsl::debug($params['title'] ?: 'Debug', $params, 'memory');
        }
    }
}
