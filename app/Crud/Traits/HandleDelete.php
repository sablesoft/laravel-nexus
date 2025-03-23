<?php

namespace App\Crud\Traits;

use Flux\Flux;

trait HandleDelete
{
    public ?int $deleteId = null;

    public function delete(int $id): void
    {
        $this->deleteId = $id;
        Flux::modal('delete-confirmation')->show();
    }

    public function deleteConfirmed(): void
    {
        $this->close();
        $this->resetCursor();
        $this->getModel($this->deleteId)?->delete();
        $this->deleteId = null;
        Flux::modal('delete-confirmation')->close();
        $this->dispatch('flash', message: $this->classTitle(false) . ' deleted');
    }
}
