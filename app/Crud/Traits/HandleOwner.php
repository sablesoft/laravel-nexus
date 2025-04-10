<?php

namespace App\Crud\Traits;

use App\Models\Interfaces\HasOwnerInterface;

trait HandleOwner
{
    /**
     * @param HasOwnerInterface $model
     * @return string
     */
    protected function getUserName(HasOwnerInterface $model): string
    {
        return $model->user->name;
    }

    /**
     * @param string $title
     * @return array
     */
    protected function userField(string $title = 'User'): array
    {
        return [
            'title' => $title,
            'action' => ['index', 'view'],
            'callback' => 'getUserName',
            'rules' => 'required|string',
        ];
    }

    protected function isPublicField(array $action = ['edit', 'view']): array
    {
        return [
            'title' => __('Public'),
            'action' => $action,
            'type' => 'checkbox',
            'rules' => 'bool',
            'callback' => fn($model) => $model->is_public ? 'Yes' : 'No'
        ];
    }
}
