<?php

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Interfaces\ShouldHasMany;
use App\Crud\Traits\HandleHasMany;
use App\Crud\Traits\HandleImage;
use App\Crud\Traits\HandleLinks;
use App\Livewire\Filters\FilterIsPublic;
use App\Logic\Rules\DslRule;
use App\Logic\Validators\BehaviorsValidator;
use App\Logic\Validators\EffectsValidator;
use App\Logic\Validators\StatesValidator;
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
//            'title' => __('Title'), todo!!
            'is_public' => __('Public')
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
            'screenLink' => $this->linkTemplateParams(Screen::routeName(), 'startScreen'),
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

        if ($action === 'view' && $field === 'groupsCrud') {
            return [
                'applicationId' => $this->modelId
            ];
        }

        if ($action === 'view' && $field === 'charactersCrud') {
            return [
                'application' => $this->getResource()
            ];
        }

        return [];
    }

    protected function fieldsConfig(): array
    {
        $dslEditor = config('dsl.editor', 'json');
        return array_merge([
            'title' => [
                'title' => __('Title'),
                'action' => ['index', 'create', 'edit', 'view'],
                'rules' => 'required|string',
            ],
            'image' => $this->imageViewerField(),
            'image_id' => $this->imageSelectorField(),
            'description' => [
                'title' => __('Description'),
                'action' => ['create', 'edit', 'view'],
                'type' => 'textarea',
                'rules' => 'nullable|string'
            ],
            'is_public' => [
                'title' => __('Public'),
                'hint' => __('Is application visible in catalog'),
                'action' => ['index', 'edit', 'view'],
                'type' => 'checkbox',
                'callback' => fn($model) => $model->is_public ? __('Yes') : __('No'),
                'rules' => [
                    'bool',
                    function ($attribute, $value, $fail) {
                        if ($value === true) {
                            if (is_null($this->state['image_id'])) {
                                $fail('You cannot make this application public without an image.');
                            }
                            if (!$this->getResource()->startScreen) {
                                $fail('You cannot make this application public without a init screen.');
                            }
                        }
                    },
                ],
            ],
            'seats' => [
                'title' => __('Players Count'),
                'action' => ['index', 'view', 'edit', 'create'],
                'type' => 'number'
            ],
            'statesString' => [
                'title' => __('Global States'),
                'hint' => __('This states can be used around all screens'),
                'action' => ['edit', 'view'],
                'type' => 'codemirror',
                'rules' => ['nullable', $dslEditor, new DslRule(StatesValidator::class, $dslEditor)],
                'collapsed' => true
            ],
            'initString' => [
                'title' => __('Init'),
                'hint' => __('application.effects.init'),
                'action' => ['edit', 'view'],
                'type' => 'codemirror',
                'rules' => ['nullable', $dslEditor, new DslRule(EffectsValidator::class, $dslEditor)],
                'collapsed' => true
            ],
            'beforeString' => [
                'title' => __('Before Effects'),
                'hint' => __('application.effects.before'),
                'action' => ['edit', 'view'],
                'type' => 'codemirror',
                'rules' => ['nullable', $dslEditor, new DslRule(EffectsValidator::class, $dslEditor)],
                'collapsed' => true
            ],
            'afterString' => [
                'title' => __('After Effects'),
                'hint' => __('application.effects.after'),
                'action' => ['edit', 'view'],
                'type' => 'codemirror',
                'rules' => ['nullable', $dslEditor, new DslRule(EffectsValidator::class, $dslEditor)],
                'collapsed' => true
            ],
            'screenLink' => $this->linkField(__('Start Screen'), ['index', 'view']),
            'screensList' => $this->linkListField(__('Screens'), ['index', 'view']),
            'characterStatesString' => [
                'title' => __('Character States'),
                'action' => ['edit', 'view'],
                'type' => 'codemirror',
                'rules' => ['nullable', $dslEditor, new DslRule(StatesValidator::class, $dslEditor)],
                'collapsed' => true
            ],
            'behaviorsString' => [
                'title' => __('Common Behaviors'),
                'action' => ['edit', 'view'],
                'type' => 'codemirror',
                'rules' => ['nullable', $dslEditor, new DslRule(BehaviorsValidator::class, $dslEditor)],
                'collapsed' => true
            ],
            'groupsCrud' => [
                'title' => __('Roles'),
                'action' => ['view'],
                'type' => 'component',
                'component' => 'workshop.application.chat-groups',
                'showEmpty' => true,
                'collapsed' => true
            ],
        ], $this->action === 'view' && $this->getResource()->startScreen ? [
            'charactersCrud' => [
                'title' => __('Characters'),
                'action' => ['view'],
                'type' => 'component',
                'component' => 'characters',
                'showEmpty' => true,
                'collapsed' => true
            ],
        ]: []);
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
