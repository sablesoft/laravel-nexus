<?php

namespace App\Livewire\Workshop\Screen;

use Livewire\Attributes\Locked;
use Livewire\Attributes\On;

trait HandleTransfers
{
    #[Locked]
    public array $transfersAdded = [];
    #[Locked]
    public array $transfersDeleted = [];
    #[Locked]
    public array $transfersUpdated = [];

    #[On('transferAdded')]
    public function addTransfer(array $transfer): void
    {
        $screenToId = $transfer['screen_to_id'];
        $this->transfersAdded[$screenToId] = $transfer;
        if (array_key_exists($screenToId, $this->transfersDeleted)) {
            unset($this->transfersDeleted[$screenToId]);
            $this->transfersUpdated[$screenToId] = $transfer;
        }
    }

    #[On('transferRemoved')]
    public function removeTransfer(int $screenToId): void
    {
        unset($this->transfersUpdated[$screenToId]);
        if( array_key_exists($screenToId, $this->transfersAdded)) {
            unset($this->transfersAdded[$screenToId]);
        } else {
            $this->transfersDeleted[$screenToId] = true;
        }
    }

    #[On('transferUpdated')]
    public function updateTransfer(array $transfer): void
    {
        $screenToId = $transfer['screen_to_id'];
        if (array_key_exists($screenToId, $this->transfersAdded)) {
            $this->transfersAdded[$screenToId] = $transfer;
        } else {
            $this->transfersUpdated[$screenToId] = $transfer;
        }
    }

    public function componentParams(string $action, ?string $field = null): array
    {
        if ($action === 'edit' && $field === 'transfersEdit') {
            return ['screenId' => $this->modelId];
        }

        return [];
    }

    protected function transfersEditField(): array
    {
        return [
            'title' => 'Transfers',
            'action' => ['edit'],
            'type' => 'component',
            'component' => 'workshop.screen.transfer',
            'callback' => fn($model) => $this->getHasManyHtml($model, 'transfers')
        ];
    }

    protected function transfersViewField(): array
    {
        return [
            'title' => 'Transfers',
            'action' => 'view',
            'type' => 'template',
            'template' => 'components.screen.transfers'
        ];
    }
}
