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

    protected function linkListField(string $title, array $action = ['view']): array
    {
        return [
            'title' => $title,
            'action' => $action,
            'type' => 'template',
            'template' => 'crud.link-list',
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

    protected function linkListTemplateParams(string $route, string $target, bool $isMethod = false): callable
    {
        return function(Model $model) use ($target, $isMethod, $route) {
            $targetModels = $this->linkTarget($model, $target, $isMethod);
            if (!count($targetModels)) {
                return [];
            }
            $list = [];
            foreach ($targetModels as $targetModel) {
                $list[$targetModel->id] = $targetModel->title;
            }
            return compact('list', 'route');
        };
    }

    private function linkTarget(Model $model, string $target, bool $isMethod): mixed
    {
        return $isMethod ? $model->$target() : $model->$target;
    }
}
