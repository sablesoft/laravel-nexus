<?php

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Interfaces\ShouldHasMany;
use App\Crud\Traits\HandleHasMany;
use App\Crud\Traits\HandleImage;
use App\Crud\Traits\HandleLinks;
use App\Livewire\Filters\FilterIsPublic;
use App\Services\OpenAI\Enums\ImageAspect;
use Illuminate\Database\Eloquent\Builder;

class Application extends AbstractCrud implements ShouldHasMany
{
    use HandleHasMany, HandleImage, FilterIsPublic, HandleLinks;

    public function className(): string
    {
        return \App\Models\Application::class;
    }

    public static function routeName(): string
    {
        return 'workshop.applications';
    }

    public function orderByFields(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'is_public' => 'Is Public'
        ];
    }

    public function templateParams(string $action, ?string $field = null): array|callable
    {
        if (array_key_exists($field, $this->getHasManyFields())) {
            $class = $this->getHasManyFields()[$field];
            return $this->optionsParam($field, $class);
        }

        return match ($field) {
            'screen_id' => $this->optionsParam($field, \App\Models\Screen::class),
            'screenLink' => $this->linkTemplateParams(Screen::routeName(), 'initScreen'),
            'screensList' => $this->linkListTemplateParams(Screen::routeName(), 'screens'),
            default => [],
        };
    }

    public function componentParams(string $action, ?string $field = null): array
    {
        if ($field === 'image_id') {
            /** @var \App\Models\Application $model */
            $model = $this->getModel($this->modelId);
            return $this->componentParamsImageSelector($field, $model->image_id, [
                'aspectRatio' => ImageAspect::Landscape->value
            ]);
        }

        return [];
    }

    protected function fieldsConfig(): array
    {
        $dslEditor = config('dsl.editor', 'json');
        return [
            'title' => [
                'action' => ['index', 'create', 'edit', 'view'],
                'rules' => 'required|string',
            ],
            'image' => $this->imageViewerField(),
            'image_id' => $this->imageSelectorField(),
            'description' => [
                'action' => ['create', 'edit', 'view'],
                'type' => 'textarea',
                'rules' => 'nullable|string'
            ],
            'is_public' => [
                'title' => 'Public',
                'action' => ['index', 'edit', 'view'],
                'type' => 'checkbox',
                'callback' => fn($model) => $model->is_public ? 'Yes' : 'No',
                'rules' => [
                    'bool',
                    function ($attribute, $value, $fail) {
                        if ($value === true) {
                            if (is_null($this->state['image_id'])) {
                                $fail('You cannot make this application public without an image.');
                            }
                            if (!$this->getResource()->initScreen) {
                                $fail('You cannot make this application public without a init screen.');
                            }
                        }
                    },
                ],
            ],
            'beforeString' => [
                'title' => 'Before',
                'action' => ['edit', 'view'],
                'type' => 'codemirror',
                'rules' => "nullable|$dslEditor",
                'collapsed' => true
            ],
            'afterString' => [
                'title' => 'After',
                'action' => ['edit', 'view'],
                'type' => 'codemirror',
                'rules' => "nullable|$dslEditor",
                'collapsed' => true
            ],
            'screenLink' => $this->linkField('Init Screen', ['index', 'view']),
            'screensList' => $this->linkListField('Screens', ['index', 'view']),
        ];
    }

    protected function modifyQuery(Builder $query): Builder
    {
        return $this->applyFilterIsPublic($query)->with(['image', 'screens']);
    }

    public function getHasManyFields(): array
    {
        return [
            'screens' => \App\Models\Screen::class
        ];
    }

    protected function paginationProperties(): array
    {
        return ['orderBy', 'orderDirection', 'perPage', 'search', ...$this->filterIsPublicProperties()];
    }

    public function filterTemplates(): array
    {
        return $this->filterIsPublicTemplates();
    }
}
