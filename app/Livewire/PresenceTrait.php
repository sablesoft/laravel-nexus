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

    public function here(array $members): void
    {
        $this->userIds = array_column($members, 'id');
        $this->handleHere();
    }

    public function leaving(int $id): void
    {
        $this->userIds = array_values(array_diff($this->userIds, [$id]));
        $this->handleLeaving($id);
    }

    public function joining(int $id): void
    {
        $this->userIds[] = $id;
        $this->userIds = array_unique($this->userIds);
        $this->handleJoining($id);
    }

    protected function handleHere(): void {}
    protected function handleJoining(int $id): void {}
    protected function handleLeaving(int $id): void {}
}
