<?php

namespace App\Logic\Dsl\Adapters;

use App\Models\ChatRole;
use App\Models\Member;

/**
 * @property Member $model
 * @property-read string $asString
 */
class MemberDslAdapter extends ModelDslAdapter
{
    public function getAsStringAttribute(): string
    {
        $mask = $this->model->mask;
        $data = [
            'name' => $mask->name,
            'gender' => $mask->gender,
            'description' => $mask->description,
            'roles' => $this->model->chatRoles->pluck('description', 'name')->all()
        ];

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}
