<?php

namespace App\Services\OpenAI\Chat;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Log;

class Request extends \App\Services\OpenAI\Request implements Arrayable
{
    const MESSAGE_ROLE_SYSTEM = 'system';
    const MESSAGE_ROLE_USER = 'user';
    const MESSAGE_ROLE_ASSISTANT = 'assistant';
    const MESSAGE_ROLES = [
        self::MESSAGE_ROLE_SYSTEM,
        self::MESSAGE_ROLE_USER,
        self::MESSAGE_ROLE_ASSISTANT,
    ];

    protected array $messages = [];
    protected array $tools = [];

    /**
     * @param array $tool
     * @return $this
     */
    public function addTool(array $tool): self
    {
        $this->validateTool($tool);
        $this->tools[] = $tool;
        return $this;
    }

    /**
     * @param array $tools
     * @return $this
     */
    public function addTools(array $tools): self
    {
        foreach ($tools as $tool) {
            $this->addTool($tool);
        }
        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function addToolChoice(string $name): self
    {
        $this->addParam('tool_choice', [
            'type' => 'function',
            'function' => [
                'name' => $name
            ]
        ]);
        return $this;
    }

    /**
     * @param array $message
     * @return $this
     */
    public function addMessage(array $message): self
    {
        $this->validateMessage($message);
        $this->messages[] = $message;
        return $this;
    }

    /**
     * @param array $messages
     * @return $this
     */
    public function addMessages(array $messages): self
    {
        foreach ($messages as $message) {
            $this->addMessage($message);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'messages' => $this->messages,
            'tools' => $this->tools
        ]);
    }

    /**
     * @param array $message
     * @return void
     */
    protected function validateMessage(array $message): void
    {
        if (empty($message['role']) || empty($message['content'])) {
            Log::error('[OpenAI][Chat][Request] Invalid chat message', [
                'message' => $message
            ]);
            throw new \InvalidArgumentException('Invalid chat message');
        }
        if (!in_array($message['role'], self::MESSAGE_ROLES)) {
            Log::error('[OpenAI][Chat][Request] Invalid chat message role', [
                'message' => $message
            ]);
            throw new \InvalidArgumentException('Invalid chat message role');
        }
    }

    /**
     * @param array $tool
     * @return void
     */
    protected function validateTool(array $tool): void
    {
        if (empty($tool['type']) || $tool['type'] !== 'function') {
            Log::error('[OpenAI][Chat][Request] Invalid tool type', [
                'tool' => $tool
            ]);
            throw new \InvalidArgumentException('Unknown chat tool type: ' . $tool['type']);
        }
        if (empty($tool['function'])) {
            $error = 'Function config is required for chat tool';
            Log::error("[OpenAI][Chat][Request] $error", [
                'tool' => $tool
            ]);
            throw new \InvalidArgumentException($error);
        }
    }
}
