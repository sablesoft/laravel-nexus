<?php
/** @noinspection PhpUndefinedClassInspection */

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Traits\HandleOwner;
use App\Crud\Traits\HandleUnique;
use App\Jobs\GenerateImage;
use App\Services\OpenAI\Enums\ImageAspect;
use App\Services\OpenAI\Images\Request;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Throwable;

class Image extends AbstractCrud
{
    use HandleOwner, HandleUnique;
    use WithFileUploads;

    #[Validate('required|image|max:10240')]
    public ?TemporaryUploadedFile $image = null;

    public function className(): string
    {
        return \App\Models\Image::class;
    }

    protected function fieldsConfig(): array
    {
        return [
            'path' => [
                'title' => 'File',
                'action' => ['index', 'create', 'edit', 'view'],
                'type' => 'image',
                'callback' => fn($model) => $model->path ? Storage::url($model->path) : null,
                'rules' => ['string', $this->uniqueRule('images', 'path')],
            ],
            'title' => [
                'action' => ['index', 'create', 'edit', 'view', 'generate'],
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
            ],
            'has_glitches' => [
                'title' => 'Has Glitches',
                'action' => ['view', 'edit', 'index'],
                'type' => 'checkbox',
                'rules' => 'required|bool',
                'callback' => fn($model) => $model->has_glitches ? 'Yes' : 'No'
            ],
            'attempts' => [
                'action' => ['view'],
                'type' => 'number',
                'rules' => 'required|number'
            ],
            'style' => [
                'action' => ['generate'],
                'type' => 'select',
                'rules' => 'required|string'
            ],
            'quality' => [
                'action' => ['generate'],
                'type' => 'select',
                'rules' => 'required|string'
            ],
        ];
    }

    public function getImageRatio(int $modelId): ?string
    {
        return $this->getModel($modelId)?->aspect;
    }

    public function orderByFields(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'aspect' => 'Ratio',
            'has_glitches' => 'Glitches'
        ];
    }

    public function indexButtons(): array
    {
        return [
            'generateForm' => __('Generate'),
            'create' => __('Create'),
        ];
    }

    public function selectOptions(string $field): array
    {
        return match ($field) {
            'aspect' => ImageAspect::options(),
            'quality' => Request::qualities(),
            'style' => Request::styles(),
            default => [],
        };
    }

    public function generateForm(): void
    {
        $this->resetState();
        $this->action = 'generate';
        $this->formAction = 'generate';
        $this->state['size'] = Request::DEFAULT_SIZE;
        $this->state['quality'] = Request::DEFAULT_QUALITY;
        $this->state['style'] = Request::DEFAULT_STYLE;
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

    /**
     * @return void
     * @throws Throwable
     */
    public function store(): void
    {
        try {
            if ($this->image) {
                $path = $this->image->store(path: 'public/images');
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
}
