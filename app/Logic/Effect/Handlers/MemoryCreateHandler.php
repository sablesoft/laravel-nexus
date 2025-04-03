<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Process;
use App\Models\Memory;

/**
 * Runtime handler for the `memory.create` effect.
 * Resolves all input parameters and creates a new memory record in the database.
 * If the `type` is not explicitly defined, it defaults to the current screen code.
 *
 * Context:
 * - Resolved via `EffectHandlerRegistry` using the key `"memory.create"`.
 * - Works with `MemoryCreateDefinition` for validation and structure.
 * - Uses `ValueResolver` to evaluate both literal and DSL-based fields.
 * - Persists to the `memories` table using the `Memory` Eloquent model.
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
