<?php
/** @noinspection PhpUndefinedClassInspection */

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Traits\HandleOwner;
use App\Crud\Traits\HandleUnique;
use App\Jobs\GenerateImage;
use App\Jobs\RegenerateImage;
use App\Jobs\ScaleImage;
use App\Livewire\Filters\FilterImage;
use App\Livewire\Filters\FilterIsPublic;
use App\Services\OpenAI\Enums\ImageAspect;
use App\Services\OpenAI\Enums\ImageQuality;
use App\Services\OpenAI\Enums\ImageStyle;
use App\Services\OpenAI\Images\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Throwable;

class Image extends AbstractCrud
{
    use HandleOwner, HandleUnique, FilterIsPublic, FilterImage;
    use WithFileUploads;

    #[Validate('required|image|max:10240')]
    public ?TemporaryUploadedFile $image = null;

    public function className(): string
    {
        return \App\Models\Image::class;
    }

    public static function routeName(): string
    {
        return 'workshop.images';
    }
    #[On('refresh.images')]
    public function refresh(): void
    {
        if ($this->action === 'view') {
            $this->view($this->modelId);
        }
    }

    protected function fieldsConfig(): array
    {
        return [
            'path' => [
                'title' => __('File'),
                'action' => ['create', 'edit'],
                'type' => 'image',
                'rules' => ['string', $this->uniqueRule('images', 'path')],
            ],
            'path_md' => [
                'title' => __('File'),
                'action' => ['view'],
                'type' => 'image',
            ],
            'path_sm' => [
                'title' => __('File'),
                'action' => ['index'],
                'type' => 'image',
            ],
            'title' => [
                'title' => __('Title'),
                'action' => ['create', 'edit', 'view', 'generate'],
                'rules' => 'required|string',
            ],
            'is_public' => $this->isPublicField(['index', 'edit', 'view']),

            // generate:
            'prompt' => [
                'title' => __('Prompt'),
                'action' => ['generate', 'regenerate', 'view'],
                'type' => 'textarea',
                'placeholder' => '(ENGLISH ONLY) Describe your image...',
                'rules' => 'required|string'
            ],
            'aspect' => [
                'title' => __('Aspect Ratio'),
                'action' => ['generate', 'view', 'index', 'edit'],
                'type' => 'select',
                'options' => ImageAspect::options(),
                'rules' => 'required|string',
                'callback' => fn(\App\Models\Image $model) => $model->aspect->value
            ],
            'style' => [
                'title' => __('Style'),
                'action' => ['generate', 'view', 'index', 'edit'],
                'type' => 'select',
                'options' => ImageStyle::options(),
                'rules' => 'required|string',
                'callback' => fn(\App\Models\Image $model) => $model->style->value
            ],
            'quality' => [
                'title' => __('Quality'),
                'action' => ['generate', 'view', 'index', 'edit'],
                'type' => 'select',
                'options' => ImageQuality::options(),
                'rules' => 'required|string',
                'callback' => fn(\App\Models\Image $model) => $model->quality->value
            ],

            'has_glitches' => [
                'title' => __('Has Glitches'),
                'action' => ['view', 'edit', 'index'],
                'type' => 'checkbox',
                'rules' => 'required|bool',
                'callback' => fn(\App\Models\Image $model) => $model->has_glitches ? 'Yes' : 'No'
            ],
            'attempts' => [
                'title' => __('Attempts'),
                'action' => ['view'],
                'type' => 'number',
                'rules' => 'required|number'
            ],
        ];
    }

    public function getImageRatio(int $modelId): ?string
    {
        return $this->getResource()?->aspect->value;
    }

    public function orderByFields(): array
    {
        return [
            'id' => 'ID',
            'aspect' => __('Ratio'),
            'quality' => __('Quality'),
            'style' => __('Style'),
            'has_glitches' => __('Glitches'),
            'is_public' => __('Public')
        ];
    }

    public function indexButtons(): array
    {
        return [
            'generateForm' => __('Generate'),
            'create' => __('Create'),
        ];
    }

    public function viewButtons(): array
    {
        return [
            'edit' => [
                'title' => __('Edit'),
                'variant' => 'primary',
            ],
            'scale' => [
                'title' => __('Scale'),
            ],
            'regenerateForm' => [
                'title' => __('Regenerate'),
            ],
        ];
    }

    public function regenerateForm(): void
    {
        $this->resetState();
        $this->state['prompt'] = $this->getResource()->prompt;
        $this->action = 'regenerate';
        $this->formAction = 'regenerate';
        $this->openForm();
    }

    public function generateForm(): void
    {
        $this->resetState();
        $this->action = 'generate';
        $this->formAction = 'generate';
        $this->state['aspect'] = ImageAspect::getDefault()->value;
        $this->state['quality'] = ImageQuality::getDefault()->value;
        $this->state['style'] = ImageStyle::getDefault()->value;
        $this->openForm();
    }

    /**
     * @throws Throwable
     */
    public function generate(): void
    {
        $rules = $this->actionConfig($this->action, 'rules');
        $data = $this->validate(\Arr::prependKeysWith($rules, 'state.'))['state'];
        $request = new Request();
        $request->addParams($data);
        GenerateImage::dispatch($request, auth()->user(), $data['title'] ?? null);
        $this->dispatch('flash', message: 'Your generate request is processing. Please wait.');
        $this->close();
    }

    public function regenerate(): void
    {
        $rules = $this->actionConfig($this->action, 'rules');
        $data = $this->validate(\Arr::prependKeysWith($rules, 'state.'))['state'];
        RegenerateImage::dispatch($this->getResource(), $data['prompt']);
        $this->dispatch('flash', message: 'Your regenerate request is processing. Please wait.');
        $this->close();
    }

    public function scale(): void
    {
        ScaleImage::dispatch($this->getResource());
        $this->dispatch('flash', message: 'Your scale request is processing. Please wait.');
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function store(): void
    {
        try {
            if ($this->image) {
                $path = $this->image->store(path: 'public/'. \App\Models\Image::PATH_PREFIX);
                $this->image = null;
                $this->state['path'] = $path;
            }
            parent::store();
        } catch (Throwable $e) {
            if (!empty($path)) {
                Storage::delete($path);
            }
            throw $e;
        }
    }

    protected function modifyQuery(Builder $query): Builder
    {
        $query = $this->applyFilterIsPublic($query);
        return $this->applyFilterImage($query);
    }

    protected function paginationProperties(): array
    {
        return [
            'orderBy', 'orderDirection', 'perPage', 'search',
            ...$this->filterIsPublicProperties(),
            ...$this->filterImageProperties()
        ];
    }

    public function filterTemplates(): array
    {
        return [
            ...$this->filterIsPublicTemplates(),
            ...$this->filterImageTemplates()
        ];
    }
}
