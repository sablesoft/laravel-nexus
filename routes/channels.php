<?php

use App\Livewire\Chat\Play;
use App\Models\Character;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('users.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel(Play::CHANNELS_PREFIX.'.{chatId}', function(User $user, int $chatId) {
    $query = Character::where('user_id', $user->id)
        ->where('chat_id', $chatId)
        ->where('is_confirmed', true);
    /** @var null|Character $character */
    $character = $query->first();

    return ($character) ? [
        'id' => $character->user_id
    ] : false;
});

Broadcast::channel(Play::CHANNELS_PREFIX.'.{chatId}.{screenId}', function(User $user, int $chatId, int $screenId) {
    $query = Character::where('user_id', $user->id)
        ->where('chat_id', $chatId)
        ->where('is_confirmed', true);
    /** @var null|Character $character */
    $character = $query->first();

// todo - use stored character screen

    return ($character) ? [
        'id' => $character->user_id
    ] : false;
});

Broadcast::channel('chats.view.{chatId}', function(User $user, int $chatId) {
    return [
        'id' => $user->id
    ];
});
