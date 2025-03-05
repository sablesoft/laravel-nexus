<?php /** @noinspection PhpFullyQualifiedNameUsageInspection */
/** @noinspection PhpUndefinedMethodInspection */
/** @noinspection PhpUndefinedClassInspection */

namespace App\Livewire\Workshop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Attributes\Locked;
use Livewire\Component;
use App\Models\Services\StoreService;
use App\Livewire\Workshop\Traits\HandleForm;
use App\Livewire\Workshop\Traits\HandleIndex;
use App\Livewire\Workshop\Traits\HandlePaginate;
use App\Livewire\Workshop\Interfaces\ResourceInterface;

abstract class AbstractCrud extends Component implements ResourceInterface
{
    use HandlePaginate, HandleForm, HandleIndex;

    public array $state = [];
    #[Locked]
    public string $resourceTitle;
    #[Locked]
    public string $action = 'index';
    #[Locked]
    public int $userId;

    /**
     * @return bool
     */
    public static function accessAllowed(): bool
    {
        return true;
    }

    abstract public function className(): string;

    abstract protected function fieldsConfig(): array;

    /**
     * @return void
     */
    public function mount(): void
    {
        $this->userId = auth()->id();
        $this->resourceTitle = $this->classTitle();
    }

    public function components(string $action): array
    {
        return [];
    }

    public function componentParams(string $action, ?string $field = null): array
    {
        return [];
    }

    public function templates(string $action): array
    {
        return [];
    }

    public function templateParams(string $action, ?string $field = null): array
    {
        return [];
    }

    /**
     * @param string $field
     * @param int $id
     * @return string
     */
    public function selectedOptionTitle(string $field, int $id): string
    {
        $options = $this->selectOptions($field);
        return $options[$id];
    }

    /**
     * @throws \Exception
     */
    public function render()
    {
        $params = [];
        if ($this->showForm) {
            $view = 'livewire.workshop.form';
        } elseif ($this->action === 'index') {
            $view = 'livewire.workshop.index';
            $params = [
                'models' => $this->loadModels()
            ];
        } elseif ($this->action === 'view') {
            $view = 'livewire.workshop.view';
        } else {
            throw new \Exception('Unknown workshop view');
        }

        $title = config('app.name') . ' - ' . $this->classTitle();

        return view($view, $params)->title($title);
    }

    /**
     * @return void
     */
    public function create(): void
    {
        $this->action = 'create';
        $this->resetState();
        foreach($this->fields('create') as $field) {
            $init = $this->config($field, 'init');
            if ($init) {
                $this->state[$field] = $this->$init();
            }
        }
        $this->openForm();
    }

    /**
     * @return void
     */
    public function store(): void
    {
        $rules = $this->actionConfig($this->action, 'rules');
        if ($rules) {
            $data = $this->validate(\Arr::prependKeysWith($rules, 'state.'));
        }  else {
            return;
        }
        try {
            $model = $this->getModel($this->modelId);
            StoreService::handle($data['state'], $model);
//            $this->notification($this->classTitle(false) . ($this->modelId ? ' updated' : ' created'));
            $this->close();
        } catch (\Throwable $e) {
//            $this->notification(config('app.debug') ? $e->getMessage() : 'Failed. Something wrong.', 'error');
            Log::error($e->getMessage(), ['exception' => $e]);
        }
    }


    /**
     * @return void
     */
    public function close(): void
    {
        $this->formAction = 'store';
        $this->showForm = false;
        $this->modelId = null;
        $this->action = 'index';
        $this->resetState();
    }

    /**
     * @param int $id
     * @return void
     */
    public function edit(int $id): void
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $model = $this->getModel($id);
        $this->modelId = $id;
        $this->resetState();
        foreach($this->fields('edit') as $field) {
            $this->state[$field] = $model->$field;
        }
        $this->action = 'edit';

        $this->openForm();
    }

    /**
     * @param int|null $id
     * @return void
     */
    public function view(?int $id = null): void
    {
        $id = $id ?: $this->modelId;
        if (!$id) {
            return;
        }
        $model = $this->getModel($id);
        $this->close();
        $this->modelId = $id;
        foreach($this->fields('view') as $field) {
            $this->state[$field] = $this->getValue($model, $field);
        }
        $this->action = 'view';
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $this->close();
        $this->resetCursor();
        $this->getModel($id)->delete();
        $this->notification($this->classTitle(false) . ' deleted');
    }

    /**
     * @param bool $plural
     * @return string
     */
    protected function classTitle(bool $plural = true): string
    {
        $parts = explode('\\', $this->className());
        return self::title(end($parts), $plural);
    }

    /**
     * @param string $action
     * @param string|null $option
     * @return array
     */
    protected function actionConfig(string $action, ?string $option = null): array
    {
        $config = [];
        $all = $this->fieldsConfig();
        if ($action === 'all') {
            $config = $all;
        } else {
            foreach ($all as $field => $fieldConfig) {
                if (!isset($fieldConfig['action']) || in_array($action, (array) $fieldConfig['action'])) {
                    $config[$field] = $fieldConfig;
                }
            }
        }
        if (!$option) {
            return $config;
        }

        $prepared = [];
        foreach ($config as $field => $options) {
            if (!empty($options[$option])) {
                $prepared[$field] = $options[$option];
            }
        }

        return $prepared;
    }

    /**
     * @return string[]
     */
    protected function fields(string $action): array
    {
        return array_keys($this->actionConfig($action));
    }

    /**
     * @param Model $model
     * @param string $field
     * @return string|null
     */
    protected function getValue(Model $model, string $field): ?string
    {
        $config = $this->fieldsConfig()[$field];
        if (!empty($config['callback'])) {
            $callback = $config['callback'];
            return $this->$callback($model);
        }

        return $model->$field;
    }

    /**
     * @param int|null $id
     * @return Model|null
     */
    protected function getModel(?int $id = null): ?Model
    {
        $className = $this->className();
        return $id ? $className::findOrFail($id) : new $className();
    }

    /**
     * @return void
     */
    protected function resetState(): void
    {
        foreach($this->fields('all') as $field) {
            $this->state[$field] = null;
        }
    }

    /**
     * @param string $message
     * @param string $type
     * @return void
     */
    protected function notification(string $message, string $type = 'message'): void
    {
        $this->dispatch('notification', params: [
            'flash' => $type,
            'message' => $message
        ]);
    }


    /**
     * @param string $name
     * @param bool $plural
     * @return string
     */
    public static function code(string $name, bool $plural = false): string
    {
        return Str::of($name)->kebab()->plural($plural ? 2 : 1);
    }

    /**
     * @param string $name
     * @param bool $plural
     * @return string
     */
    public static function title(string $name, bool $plural = false): string
    {
        return Str::of(self::code($name, $plural))->replace('-', ' ')->title();
    }
}
