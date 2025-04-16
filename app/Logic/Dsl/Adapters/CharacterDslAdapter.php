<?php

namespace App\Logic\Dsl\Adapters;

use App\Models\ChatRole;
use App\Models\Character;

/**
 * @property Character $model
 * @property-read string $asString
 */
class CharacterDslAdapter extends ModelDslAdapter
{
    public function getAsStringAttribute(): string
    {
        $mask = $this->model->mask;
        $data = [
            'name' => $mask->name,
            'gender' => $mask->gender,
            'description' => $mask->description,
            'roles' => $this->model->roles->pluck('description', 'name')->all()
        ];

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}
