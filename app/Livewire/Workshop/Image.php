<?php
/** @noinspection PhpUndefinedClassInspection */

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Traits\HandleOwner;
use App\Crud\Traits\HandleUnique;
use App\Jobs\GenerateImage;
use App\Jobs\ScaleImage;
use App\Livewire\Filters\FilterImage;
use App\Livewire\Filters\FilterIsPublic;
use App\Services\OpenAI\Enums\ImageAspect;
use App\Services\OpenAI\Enums\ImageQuality;
use App\Services\OpenAI\Enums\ImageStyle;
use App\Services\OpenAI\Images\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
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

    protected function fieldsConfig(): array
    {
        return [
            'path' => [
                'title' => 'File',
                'action' => ['index', 'create', 'edit', 'view'],
                'type' => 'image',
                'rules' => ['string', $this->uniqueRule('images', 'path')],
            ],
            'title' => [
                'action' => ['create', 'edit', 'view', 'generate'],
                'rules' => 'required|string',
            ],
            'is_public' => $this->isPublicField(['index', 'edit', 'view']),

            // generate:
            'prompt' => [
                'action' => ['generate', 'view'],
                'type' => 'textarea',
                'placeholder' => '(ENGLISH ONLY) Describe your image...',
                'rules' => 'required|string'
            ],
            'aspect' => [
                'title' => 'Aspect Ratio',
                'action' => ['generate', 'view', 'index', 'edit'],
                'type' => 'select',
                'rules' => 'required|string',
                'callback' => fn(\App\Models\Image $model) => $model->aspect->value
            ],
            'has_glitches' => [
                'title' => 'Has Glitches',
                'action' => ['view', 'edit', 'index'],
                'type' => 'checkbox',
                'rules' => 'required|bool',
                'callback' => fn(\App\Models\Image $model) => $model->has_glitches ? 'Yes' : 'No'
            ],
            'attempts' => [
                'action' => ['view'],
                'type' => 'number',
                'rules' => 'required|number'
            ],
            'style' => [
                'action' => ['generate', 'view', 'index', 'edit'],
                'type' => 'select',
                'rules' => 'required|string',
                'callback' => fn(\App\Models\Image $model) => $model->style->value
            ],
            'quality' => [
                'action' => ['generate', 'view', 'index', 'edit'],
                'type' => 'select',
                'rules' => 'required|string',
                'callback' => fn(\App\Models\Image $model) => $model->quality->value
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
            'aspect' => 'Ratio',
            'quality' => 'Quality',
            'style' => 'Style',
            'has_glitches' => 'Glitches',
            'is_public' => 'Is Public'
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
            ]
        ];
    }

    public function selectOptions(string $field): array
    {
        return match ($field) {
            'aspect' => ImageAspect::options(),
            'quality' => ImageQuality::options(),
            'style' => ImageStyle::options(),
            default => [],
        };
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
