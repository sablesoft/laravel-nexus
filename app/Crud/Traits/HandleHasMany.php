<?php

namespace App\Crud\Traits;

use Illuminate\Database\Eloquent\Model;

trait HandleHasMany
{
    /**
     * @param string $relation
     * @param array $action
     * @return array
     */
    protected function hasManyField(string $relation, array $action = ['index', 'view']): array
    {
        return [
            'action' => $action,
            'callback' => fn($model) => $this->getHasManyHtml($model, $relation),
        ];
    }

    /**
     * @param Model $model
     * @param string $relation
     * @return string|null
     */
    protected function getHasManyHtml(Model $model, string $relation): ?string
    {
        $html = '';
        foreach ($model->$relation as $related) {
            $html .= "<li>" . $related->title  ."</li>";
        }

        return $html ? "<ul>" . $html . "</ul>" : null;
    }
}
