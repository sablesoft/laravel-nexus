<?php

namespace App\Logic\Dsl\Adapters;

use App\Logic\Dsl\ValueResolver;
use App\Logic\Facades\Dsl;
use App\Logic\Process;
use App\Models\Interfaces\HasNotesInterface;

class MediaDslAdapter
{
    public function __construct(
        protected Process $process, // Execution context, allowing all adapters to interact with each other and with data via this mutual process
        protected HasNotesInterface $model // The wrapped Eloquent node model (must be present)
    ) {}

    public function note(string $code): ?string
    {
        $this->log('Note', ['code' => $code]);
        $content = $this->model->note($code)?->content;
        if ($content) {
            $content = ValueResolver::resolve(Dsl::prefixed($content), $this->process->toContext());
        }

        return $content;
    }

    /**
     * Logs important events within the adapter — such as attribute access or access denial.
     */
    protected function log(string $message, array $context = [], string $level = 'debug'): void
    {
        $className = class_basename($this->model);
        if ($level === 'debug') {
            Dsl::debug("[$className] $message", $context, 'adapter');
        } else {
            logger()->{$level}("[DSL][$className] " . $message, $context);
        }
    }
}
