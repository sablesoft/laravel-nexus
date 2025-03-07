<?php

namespace App\Services\OpenAI;

use App\Models\User;

interface ToolInterface
{
    /**
     * @param User $user
     * @param array $params
     * @return ToolResult
     */
    public static function handle(User $user, array $params): ToolResult;
    public static function function(): array;
}
