<?php

namespace App\Logic\Dsl\Adapters;

use App\Logic\Contracts\DslAdapterContract;
use App\Logic\Process;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use UnitEnum;

/**
 * @property-read null|int $id
 */
class ModelDslAdapter implements DslAdapterContract
{
    public function __construct(
        protected Process $process,
        protected ?Model $model = null
    ) {}

    public function __get(string $name): mixed
    {
        $this->log("Accessing property", ['name' => $name]);

        // Check if the adapter has its own accessor
        $accessor = 'get' . Str::studly($name) . 'Attribute';
        if (method_exists($this, $accessor)) {
            $this->log("Adapter accessor resolved", ['name' => $name]);
            return $this->{$accessor}();
        }

        if ($this->model->hasAttribute($name)) {
            $this->log("Model attribute value resolved", ['name' => $name]);
            return $this->filterValue($this->model->getAttributeValue($name));
        }

        $this->log("Property not allowed", ['name' => $name], 'warning');
        return null;
    }

    protected function filterValue(mixed $value): mixed
    {
        $this->log("Filtering value", ['value' => get_debug_type($value)]);

        if (is_scalar($value) || is_null($value)) {
            return $value;
        }

        if (is_array($value)) {
            return $value;
        }

        if ($value instanceof UnitEnum) {
            return $value->value;
        }

        if ($value instanceof CarbonInterface) {
            return new CarbonDslAdapter($value);
        }

        if ($value instanceof Model || $value instanceof Collection) {
            $this->log(
                "Blocked access to model relation object",
                ['relation' => get_class($value)],
                'warning'
            );
            return null;
        }

        $this->log(
            "Non-scalar value is not allowed in DSL",
            ['value' => get_debug_type($value)],
            'warning'
        );
        return null;
    }

    protected function log(string $message, array $context = [], string $level = 'debug'): void
    {
        $className = class_basename($this->model);
        logger()->{$level}("[DSL][$className] " . $message, $context);
    }

    public function id(): ?int
    {
        return $this->model->getKey();
    }
}
