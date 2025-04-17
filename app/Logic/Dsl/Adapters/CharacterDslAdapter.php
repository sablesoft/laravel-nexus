<?php

namespace App\Logic\Dsl\Adapters;

use App\Logic\Facades\Dsl;
use App\Logic\Process;
use App\Models\Character;
use Illuminate\Support\Arr;

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

    public function behaviorsInfo(?array $only = null): ?array
    {
        if (!$this->model->getKey()) {
            return null;
        }

        $result = [];
        $compiled = $this->model->behaviors['can'] ?? [];
        $verbs = $only ?: array_keys($compiled);
        foreach ($verbs as $verb) {
            if ($this->can($verb)) {
                $result[$verb] = Arr::except($compiled[$verb], ['condition', 'merge']);
            }
        }

        return $result ?: null;
    }

    public function can(string $verb): bool
    {
        $compiled = $this->model->behaviors['can'] ?? [];
        if (!array_key_exists($verb, $compiled)) {
            return false;
        }
        $condition = $compiled[$verb]['condition'] ?? null;
        return !$condition || Dsl::evaluate($condition, $this->process()->toContext());
    }

    public function is(string $roleCode): bool
    {
        return !!$this->model->roles->where('code', $roleCode)->count();
    }

    protected function process(): Process
    {
        return $this->process->character->getKey() == $this->model->getKey() ?
            $this->process :
            $this->process->clone(['character' => $this->model]);
    }
}
