<?php

use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('users.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chats.play.{chatId}', function(User $user, int $chatId) {
    $query = Member::where('user_id', $user->id)
        ->where('chat_id', $chatId)
        ->where('is_confirmed', true);
    /** @var null|Member $member */
    $member = $query->first();

    return ($member) ? [
        'id' => $member->user_id
    ] : false;
});

Broadcast::channel('chats.play.{chatId}.{screenId}', function(User $user, int $chatId, int $screenId) {
    $query = Member::where('user_id', $user->id)
        ->where('chat_id', $chatId)
        ->where('is_confirmed', true);
    /** @var null|Member $member */
    $member = $query->first();

// todo - use stored member screen

    return ($member) ? [
        'id' => $member->user_id
    ] : false;
});

Broadcast::channel('chats.view.{chatId}', function(User $user, int $chatId) {
    return [
        'id' => $user->id
    ];
});
