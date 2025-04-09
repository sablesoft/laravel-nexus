<?php

namespace App\Logic\Dsl\Adapters;

use App\Models\ChatScreenState;

class ScreenDslAdapter extends ModelDslAdapter
{
    public function state(string $key): mixed
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

        return $screenState->getState($key);
    }
}
