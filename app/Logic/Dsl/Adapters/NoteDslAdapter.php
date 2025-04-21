<?php

namespace App\Logic\Dsl\Adapters;

use App\Logic\Dsl\ValueResolver;
use App\Logic\Facades\Dsl;
use App\Logic\Process;
use App\Models\Interfaces\HasNotesInterface;

class NoteDslAdapter
{
    public function __construct(
        protected Process $process, // Execution context, allowing all adapters to interact with each other and with data via this mutual process
        protected HasNotesInterface $model // The wrapped Eloquent node model (must be present)
    ) {}

    public function content(string $code): string
    {
        $this->log('Note', ['code' => $code]);
        $content = $this->model->note($code)?->content;
        if ($content) {
            try {
                $content = ValueResolver::resolve(Dsl::prefixed($content), $this->process->toContext());
            } catch (\Throwable) {}
        } else {
            throw new \LogicException("Note not found: ". $code);
        }

        return $content;
    }

    public function message(string $code, ?string $prefix = null, string $role = 'system', string $type = 'note'): array
    {
        $content = match ($type) {
            'note' => $this->content($code),
            default => throw new \InvalidArgumentException('Unknown media message type: ' . $type)
        };
        $content = $prefix ? $prefix.' '.$content : $content;
        $role = in_array($role, ['user', 'assistant', 'system', 'tool']) ? $role : 'system';

        return [
            'role' => $role,
            'content' => $content
        ];
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
