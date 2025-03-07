<?php

namespace App\Services\OpenAI\Chat;

use OpenAI\Client;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class Action
{
    const DEFAULT_GPT_MODEL = 'gpt-3.5-turbo';

    /**
     * @param Client $client
     * @param User $user
     * @param Request $request
     * @return Result
     */
    public static function handle(Client $client, User $user, Request $request): Result
    {
        static::prepareRequest($request);
        Log::debug('[OpenAI][Chat] Init', [
            'request' => $request->toArray(),
            'user' => $user->only('id', 'name', 'email')
        ]);
        $response = $client->chat()->create($request->toArray());
        Log::debug('[OpenAI][Chat] Handle', [
            'user' => $user->only(['id', 'name', 'email']),
            'request' => $request->toArray(),
            'response' => $response->toArray()
        ]);

        $result = new Result($user);
        foreach ($response->choices as $choice) {
            $result->handleChoice($choice);
        }

        return $result;
    }

    /**
     * @param Request $request
     * @return void
     */
    protected static function prepareRequest(Request $request): void
    {
        if (!$request->getModel()) {
            // TODO - use gpt model from app or user settings
            $request->setModel(config('openai.gpt_model', self::DEFAULT_GPT_MODEL));
        }
    }
}
