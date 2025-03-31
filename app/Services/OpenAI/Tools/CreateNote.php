<?php

namespace App\Services\OpenAI\Tools;

use Illuminate\Support\Facades\Log;
use App\Models\Note;
use App\Models\User;
use App\Services\OpenAI\ToolResult;
use App\Services\OpenAI\ToolInterface;

class CreateNote implements ToolInterface
{
    /**
     * @param User $user
     * @param array $params
     * @return ToolResult
     */
    public static function handle(User $user, array $params): ToolResult
    {
        $params = array_merge($params, ['user_id' => $user->id]);
        Log::debug('[Tools][CreateNote] Handle', $params);

        $result = new ToolResult(self::class);
        if ($note = Note::create($params)) {
            $result->add('note', $note);
        } else {
            $result->markFailed();
        }

        return $result;
    }

    /**
     * @return array[]
     */
    public static function messages(array $context = [], int $count = 1): array
    {
        $main = <<<MESSAGE
You are an AI assistant that helps users generate new notes based on their prompts and selected context.
Your primary task is to understand the user's request, incorporate the provided context, and use the CreateNote tool to create a new note.
Ensure the new note is relevant to the user's request and context.
Always use the CreateNote tool for generating the note content in response to the user's prompt, regardless of the phrasing of the user's request.
Choose names for the entities described in the notes you create and use them as note titles.
MESSAGE;
        $messages = array_merge([
            [
                'role' => 'system',
                'content' => $main
            ]
        ], $context);
        if ($count > 1) {
            $countMessage = <<<ADDITIONAL
The user has requested multiple distinct notes. Your task is to generate {$count} unique notes. Each note should describe a different item or goal relevant to the user's prompt.
Ensure that each note has a unique title and content, avoiding repetition of descriptions.
Always use the CreateNote tool for each note and maintain relevance to the user's request and context.
ADDITIONAL;

            $messages[] = [
                'role' => 'system',
                'content' => $countMessage
            ];
        }

        return $messages;
    }

    /**
     * @return array[]
     */
    public static function function(): array
    {
        return [
            'type' => 'function',
            'function' => [
                'name' => 'CreateNote',
                'description' => 'Creates a note for given request',
                'parameters' => [
                    'type' => 'object',
                    'properties' => [
                        'title' => [
                            'type' => 'string',
                        ],
                        'text' => [
                            'type' => 'string',
                        ],
                    ],
                    'required' => ['title', 'text'],
                ],
            ],
        ];
    }
}
