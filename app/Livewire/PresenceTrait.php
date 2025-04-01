<?php

namespace App\Livewire;

use Livewire\Attributes\Locked;

trait PresenceTrait
{
    #[Locked]
    public array $userIds = [];

    protected function getListeners(): array
    {
        return [
            'usersHere' => 'here',
            'userJoining' => 'joining',
            'userLeaving' => 'leaving',
        ];
    }

    public function here(string $channel, array $users): void
    {
        $this->userIds[$channel] = array_column($users, 'id');
        $this->handleHere($channel);
    }

    public function leaving(string $channel, int $id): void
    {
        $this->userIds[$channel] = array_values(array_diff($this->userIds[$channel], [$id]));
        $this->handleLeaving($channel, $id);
    }

    public function joining(string $channel, int $id): void
    {
        $this->userIds[$channel][] = $id;
        $this->userIds[$channel] = array_unique($this->userIds[$channel]);
        $this->handleJoining($channel, $id);
    }

    protected function handleHere(string $channel): void {}
    protected function handleJoining(string $channel, int $id): void {}
    protected function handleLeaving(string $channel, int $id): void {}
}
