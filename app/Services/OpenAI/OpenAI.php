<?php

namespace App\Services\OpenAI;

use App\Models\User;
use App\Services\OpenAI\Chat\Action as ChatAction;
use App\Services\OpenAI\Chat\Request as ChatRequest;
use App\Services\OpenAI\Chat\Result as ChatResult;
use App\Services\OpenAI\Images\CreateAction as ImageCreate;
use App\Services\OpenAI\Images\Request as ImagesRequest;
use App\Services\OpenAI\Images\Result as ImagesResult;
use OpenAI\Client;
use Throwable;

class OpenAI
{
    protected User $user;
    protected Client $client;

    public function __construct(User $user)
    {
        $this->user = $user;
        // todo - use client credentials from app or user settings
        $this->client = \OpenAI::client(config('openai.api_key'), config('openai.organization'));
    }

    /**
     * @param ChatRequest $request
     * @return ChatResult
     */
    public function chat(ChatRequest $request): ChatResult
    {
        return ChatAction::handle($this->client, $this->user, $request);
    }

    /**
     * @param ImagesRequest $request
     * @return ImagesResult
     * @throws Throwable
     */
    public function imageCreate(ImagesRequest $request): ImagesResult
    {
        return ImageCreate::handle($this->client, $this->user, $request);
    }
}
