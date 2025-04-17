<?php

namespace App\Logic\Dsl\Adapters;

use App\Logic\Facades\Dsl;
use App\Models\ChatScreenState;
use App\Models\Memory;
use App\Models\Screen;

/**
 * @property Screen $model
 */
class ScreenDslAdapter extends ModelDslAdapter
{
    public function transfer(): ?string
    {
        return $this->process->screenTransfer ?
            Screen::findOrFail($this->process->screenTransfer) :
            null;
    }

    public function waiting(): bool
    {
        return $this->process->screenWaiting;
    }

    public function messages(string|int $expression = 3, int $limit = 3): array
    {
        if (!$this->process->chat->getKey()) {
            throw new \DomainException('Cannot use screen messages without chat in context');
        }
        if (!$this->model->getKey()) {
            throw new \DomainException('Cannot use screen messages without screen in context');
        }

        $query = Memory::query()
            ->where('chat_id', $this->process->chat->getKey())
            ->where('type', $this->model->code);

        if (is_int($expression)) {
            $limit = $expression;
        } else {
            $query = Dsl::apply($query, $expression, $this->process->toContext());
        }

        return Memory::toMessages(
            $query->orderByDesc('created_at')->limit($limit)->get()
        );
    }

    public function state(string $key): mixed
    {
        return $this->chatScreenState()->getState($key);
    }

    public function nextState(string $key): mixed
    {
        return $this->chatScreenState()->nextState($key);
    }

    public function prevState(string $key): mixed
    {
        return $this->chatScreenState()->prevState($key);
    }

    public function randomState(string $key): mixed
    {
        return $this->chatScreenState()->randomState($key);
    }

    protected function chatScreenState(): ChatScreenState
    {
        $chat = $this->process->chat;
        if (!$chat->getKey()) {
            throw new \DomainException('Cannot use screen state without chat in context');
        }

        /** @var ChatScreenState|null $screenState */
        $screenState = $chat->screenStates()
            ->where('screen_id', $this->model->getKey())
            ->first();

        if (!$screenState) {
            throw new \RuntimeException("No state found for screen [{$this->model->getKey()}] in chat [{$chat->id}]");
        }

        return $screenState;
    }
}
