<?php
/** @noinspection PhpUndefinedClassInspection */

namespace App\Livewire\Workshop;

use App\Crud\AbstractCrud;
use App\Crud\Traits\HandleOwner;
use App\Crud\Traits\HandleUnique;
use App\Jobs\GenerateImage;
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

    #[Validate('required|image|max:2048')]
    public ?TemporaryUploadedFile $image = null;

    public function className(): string
    {
        return \App\Models\Image::class;
    }

    protected function fieldsConfig(): array
    {
        return [
            'thumbnail' => [
                'title' => 'File',
                'action' => ['index'],
                'type' => 'image',
                'callback' => 'getThumbnail',
            ],
            'title' => [
                'action' => ['index', 'create', 'edit', 'view', 'generate'],
                'rules' => 'required|string',
            ],
            'path' => [
                'title' => 'File',
                'action' => ['create', 'edit', 'view'],
                'type' => 'image',
                'rules' => ['string', $this->uniqueRule('images', 'path')],
            ],
            'is_public' => $this->isPublicField(),

            // generate:
            'prompt' => [
                'action' => ['generate', 'view'],
                'type' => 'textarea',
                'placeholder' => '(ENGLISH ONLY) Describe your image...',
                'rules' => 'required|string'
            ],
            'size' => [
                'action' => ['generate'],
                'type' => 'select',
                'rules' => 'required|string'
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

    /**
     * @return string[]
     */
    public function orderByFields(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title'
        ];
    }

    /**
     * @return array
     */
    public function indexButtons(): array
    {
        return [
            'generateForm' => __('Generate'),
            'create' => __('Create'),
        ];
    }

    /**
     * @param string $field
     * @return array|string[]
     */
    public function selectOptions(string $field): array
    {
        return match ($field) {
            'size' => Request::sizes(),
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
     * @return void
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

    protected function getThumbnail(\App\Models\Image $image): string
    {
        return '<img src="' . Storage::url($image->path) .
            '" class="w-32 h-32 object-cover rounded-md" alt="Thumbnail"/>';
    }
}
