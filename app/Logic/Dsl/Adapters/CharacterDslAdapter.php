<?php

namespace App\Logic\Dsl\Adapters;

use App\Logic\Act;
use App\Logic\Facades\Dsl;
use App\Logic\Process;
use App\Models\Character;

/**
 * @property Character $model
 * @property-read string $asString
 */
class CharacterDslAdapter extends ModelDslAdapter
{
    public function gender(): string
    {
        return $this->model->gender->label('en');
    }

    public function language(): string
    {
        return $this->model->language->label('en');
    }

    public function getAsStringAttribute(): string
    {
        $mask = $this->model->mask;
        $data = [
            'name' => $mask->name,
            'gender' => $mask->gender->label(),
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
        $behaviors = $this->model->behaviors['can'] ?? [];
        $verbs = $only ?: array_keys($behaviors);
        // set correct order of fields for LLM:
        $fields = array_merge(['description'], Act::propertyKeys());
        foreach ($verbs as $verb) {
            if ($this->can($verb)) {
                $behavior = $behaviors[$verb];
                $result[$verb] = collect($fields)
                    ->filter(fn($key) => array_key_exists($key, $behavior))
                    ->mapWithKeys(fn($key) => [$key => $behavior[$key]])
                    ->toArray();
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

    public function code(): string
    {
        return $this->model->code ?: 'none';
    }

    public function fromCode(string $code, ?Process $process = null): self
    {
        $model = Character::where('code', $code)->firstOrFail();
        $process = $process ?: $this->process;

        return new static($process->clone(['character' => $model]), $model);
    }

    protected function process(): Process
    {
        return $this->process->character->getKey() == $this->model->getKey() ?
            $this->process :
            $this->process->clone(['character' => $this->model]);
    }
}
