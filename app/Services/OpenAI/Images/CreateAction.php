<?php

namespace App\Services\OpenAI\Images;

use Throwable;
use OpenAI\Client;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class CreateAction
{
    const DEFAULT_IMAGE_MODEL = 'dall-e-3';

    /**
     * @param Client $client
     * @param User $user
     * @param Request $request
     * @return Result
     * @throws Throwable
     */
    public static function handle(Client $client, User $user, Request $request): Result
    {
        static::prepareRequest($request);
        Log::debug('[OpenAI][Images][Create] Init', [
            'request' => $request->toArray(),
            'user' => $user->only('id', 'name', 'email')
        ]);
        $response = $client->images()->create($request->toArray());
        Log::debug('[OpenAI][Images] Create', [
            'user' => $user->only(['id', 'name', 'email']),
            'request' => $request->toArray(),
            'response' => $response->toArray()
        ]);
        $result = new Result($user);
        $result->handle($response);

        return $result;
    }

    /**
     * @param Request $request
     * @return void
     */
    protected static function prepareRequest(Request $request): void
    {
        if (!$request->getModel()) {
            // TODO - use image model from app or user settings
            $request->setModel(config('openai.image_model', self::DEFAULT_IMAGE_MODEL));
        }
    }
}
