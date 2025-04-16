<?php

namespace App\Models\Services;

use App\Models\Chat;
use App\Models\ChatRole;

class ChatCreated
{
    public static function handle(Chat $chat): void
    {
        $application = $chat->application;
        foreach ($application->groups as $group) {
            $chatGroup = $group->replicate(['id', 'application_id', 'created_at', 'updated_at']);
            $chatGroup->chat_id = $chat->id;
            $chatGroup->save();

            foreach ($group->roles as $role) {
                $chatRole = $role->replicate(['id', 'application_id', 'created_at', 'updated_at']);
                $chatRole->chat_group_id = $chatGroup->id;
                $chatRole->chat_id = $chat->id;
                $chatRole->save();
            }
        }
        foreach ($application->members as $member) {
            $copy = $member->replicate(['id', 'application_id', 'created_at', 'updated_at']);
            $copy->chat_id = $chat->id;
            $copy->save();

            $newRoles = $member->roles->map(function ($role) use ($chat) {
                return ChatRole::query()
                    ->where('chat_id', $chat->id)
                    ->where('code', $role->code)
                    ->value('id');
            })->filter()->all();
            $copy->roles()->sync($newRoles);
        }
    }
}
