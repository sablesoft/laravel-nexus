<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Process;

/**
 * Runtime handler for the `comment` effect.
 * This effect has no functional impact on the process state.
 * It exists purely for documentation, inline explanation, or future debug/log purposes.
 *
 * Context:
 * - Registered under the key `"comment"` in the EffectHandlerRegistry.
 * - Used to annotate DSL blocks or logic branches.
 * - Can be leveraged for enhanced traceability via logs or UI introspection.
 */
class CommentHandler implements EffectHandlerContract
{
    public function __construct(protected string $value) {}

    /**
     * Return the inline comment string for logging.
     */
    public function describeLog(Process $process): ?string
    {
        return $this->value;
    }

    /**
     * No-op: does not alter the process or state.
     */
    public function execute(Process $process): void
    {
        // Intentionally left empty
    }
}
