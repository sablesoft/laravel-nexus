<?php

namespace App\Logic\Dsl\Adapters;

use App\Logic\Facades\Dsl;
use App\Logic\Process;
use App\Models\Memory;
use Illuminate\Support\Arr;

class MemoryDslAdapter extends ModelDslAdapter
{
    public function __construct(Process $process, ?Memory $model = null)
    {
        parent::__construct($process, $model ?? new Memory());
    }

    public function messages(string|int $expression = 3, int $limit = 3): array
    {
        if (!$this->process->chat->getKey()) {
            throw new \DomainException('Cannot use chat messages without chat in context');
        }

        $query = Memory::query()->where('chat_id', $this->process->chat->getKey());

        if (is_int($expression)) {
            $limit = $expression;
        } else {
            $query = Dsl::apply($query, $expression, $this->process->toContext());
        }

        $messages = Memory::toMessages(
            $query->orderByDesc('created_at')->limit($limit)->get()->reverse()
        );
        Dsl::debug('Messages', [
            'expression' => $expression,
            'limit' => $limit,
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings(),
            'messages' => $messages
        ], 'memory');

        return $messages;
    }

    public function card(string $code, string $type = 'card', bool $usePrefix = true): ?array
    {
        $expression = '":type" == "'.$type.'" and ":meta.'.$type.'" == "'.$code.'"';
        $messages = $this->messages($expression, 1);
        if ($message = reset($messages)) {
            $message['content'] = $usePrefix ?
                ucfirst($type) . ': ' . $message['content'] :
                $message['content'];
        } else {
            throw new \LogicException("Card with type '$type' found: ". $code);
        }
        return $message;
    }

    public function meta(string $path, mixed $default = null): mixed
    {
        $meta = $this->model?->getAttributeValue('meta') ?? [];

        return is_array($meta)
            ? Arr::get($meta, $path, $default)
            : $default;
    }

    public function get(string $key): mixed
    {
        return $this->model?->getAttributeValue($key);
    }

    public function set(string $key, mixed $value): true
    {
        $this->model?->setAttribute($key, $value);
        return true;
    }
}
