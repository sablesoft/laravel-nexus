<?php

namespace App\Services\OpenAI;

use Illuminate\Support\Facades\Log;
use OpenAI\Responses\Chat\CreateResponseChoice;
use App\Models\User;

class ToolCallsHandler
{
    const TOOL_CLASS_PREFIX = "\App\Services\OpenAI\Tools\\";

    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param ChoiceResult $result
     * @param CreateResponseChoice $choice
     */
    public function handle(ChoiceResult $result, CreateResponseChoice $choice): void
    {
        if (empty($choice->message->toolCalls)) {
            Log::debug('[OpenAI][ToolCallsHandler] Empty calls');
            return;
        }

        foreach ($choice->message->toolCalls as $call) {
            if ($call->type === 'function') {
                $tool = self::TOOL_CLASS_PREFIX . $call->function->name;
                if (class_exists($tool) && in_array(ToolInterface::class, class_implements($tool))) {
                    if ($arguments = $call->function->arguments) {
                        $arguments = json_decode($arguments, true);
                    } else {
                        $arguments = [];
                    }
                    /** @var ToolInterface $tool */
                    $result->addToolResult($tool::handle($this->user, $arguments));
                }
            }
        }
    }
}
