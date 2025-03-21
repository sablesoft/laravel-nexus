<?php

namespace App\Crud\Traits;

use Illuminate\Database\Eloquent\Model;

trait HandleLinks
{
    protected function linkField(string $title, array $action = ['view']): array
    {
        return [
            'title' => $title,
            'action' => $action,
            'type' => 'template',
            'template' => 'crud.link',
        ];
    }

    protected function linkTemplateParams(string $route, string $target, bool $isMethod = false): callable
    {
        return fn(Model $model) => $this->linkTarget($model, $target, $isMethod) ? [
            'route' => $route,
            'action' => 'view',
            'id' => $this->linkTarget($model, $target, $isMethod)->id,
            'title' => $this->linkTarget($model, $target, $isMethod)->title
        ] : [
            'title' => '------'
        ];
    }

    protected function linkTarget(Model $model, string $target, bool $isMethod): ?Model
    {
        return $isMethod ? $model->$target() : $model->$target;
    }
}
