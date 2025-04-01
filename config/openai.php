<?php

return [

    /*
    |--------------------------------------------------------------------------
    | OpenAI API Key and Organization
    |--------------------------------------------------------------------------
    |
    | Here you may specify your OpenAI API Key and organization. This will be
    | used to authenticate with the OpenAI API - you can find your API key
    | and organization on your OpenAI dashboard, at https://openai.com.
    */

    'api_key' => env('OPENAI_API_KEY'),
    'organization' => env('OPENAI_ORGANIZATION'),

    /*
    |--------------------------------------------------------------------------
    | Request Timeout
    |--------------------------------------------------------------------------
    |
    | The timeout may be used to specify the maximum number of seconds to wait
    | for a response. By default, the client will time out after 30 seconds.
    */

    'request_timeout' => env('OPENAI_REQUEST_TIMEOUT', 30),

    'gpt_model' => env('OPENAI_GPT_MODEL', 'gpt-4-turbo'),
    'image_model' => env('OPENAI_IMAGE_MODEL', 'dall-e-3'),
    'gpt_models' => [
        'gpt-4',             // alias for latest GPT-4 with tool support
        'gpt-4-turbo',       // faster & cheaper GPT-4
        'gpt-4-0125-preview',// explicit snapshot (tool calls, JSON mode, etc.)
        'gpt-3.5-turbo',     // fast & cheap, без функции tool calling
        'gpt-3.5-turbo-0125' // последний снапшот GPT-3.5
    ]
];
