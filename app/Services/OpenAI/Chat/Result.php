<?php

namespace App\Services\OpenAI\Chat;

use OpenAI\Responses\Chat\CreateResponseChoice;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Services\OpenAI\ChoiceResult;
use App\Services\OpenAI\ToolCallsHandler;

class Result extends \App\Services\OpenAI\Result
{

    public Collection $choiceResults;
    protected ToolCallsHandler $callsHandler;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
        $this->callsHandler = new ToolCallsHandler($this->user);
        $this->choiceResults = collect();
    }

    /**
     * @param CreateResponseChoice $choice
     * @return void
     */
    public function handleChoice(CreateResponseChoice $choice): void
    {
        $result = new ChoiceResult($choice->message->content);
        $this->callsHandler->handle($result, $choice);
        $this->choiceResults->add($result);
    }
}
