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
 * ModelDslAdapter is responsible for safe and restricted access to Eloquent model attributes
 * within DSL expressions. This adapter is automatically applied by the platform during Process
 * initialization for all core models (Chat, Screen, Member, Memory) unless they provide their own adapter.
 *
 * Its main purpose is to filter out unsafe or unwanted values, such as model relations,
 * collections, and complex objects. Only scalars, arrays, enums (UnitEnum), and Carbon dates
 * are allowed. Carbon objects are further wrapped into a CarbonDslAdapter.
 *
 * This adapter also serves as a base class for custom model-specific adapters,
 * which can extend it to introduce additional logic and methods.
 *
 * ---
 * Environment:
 * - Used internally by Process to wrap models: chat, screen, memory, member
 * - Can be replaced with a custom adapter if the model implements HasDslAdapterContract;
 *   such adapters usually extend this base class
 * - Participates in DSL evaluation: accessed via ExpressionLanguage to resolve variables
 *   and adapter methods during logic execution
 */
class ModelDslAdapter implements DslAdapterContract
{
    public function __construct(
        protected Process $process, // Execution context, allowing all adapters to interact with each other and with data via this mutual process
        protected Model $model // The wrapped Eloquent model (must be present)
    ) {}

    /**
     * Magic accessor for adapter fields in DSL expressions, e.g., member.name
     * Checks for a local accessor method first, then falls back to model attributes.
     * Any disallowed access is logged and returns null.
     */
    public function __get(string $name): mixed
    {
        // First, check for custom accessor in adapter class
        $accessor = 'get' . Str::studly($name) . 'Attribute';
        if (method_exists($this, $accessor)) {
            $this->log("Adapter accessor resolved", ['name' => $name]);
            return $this->{$accessor}();
        }

        // Then try resolving attribute from the model
        if ($this->model->hasAttribute($name)) {
            return $this->filterValue($this->model->getAttributeValue($name));
        }

        // Otherwise, reject the request
        $this->log("Property not allowed", ['name' => $name], 'warning');
        return null;
    }

    /**
     * Filters a value coming from the model, ensuring it's safe to expose in DSL.
     * Disallows models, collections, and other complex types.
     */
    protected function filterValue(mixed $value): mixed
    {
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

    /**
     * Logs important events within the adapter — such as attribute access or access denial.
     */
    protected function log(string $message, array $context = [], string $level = 'debug'): void
    {
        $className = class_basename($this->model);
        logger()->{$level}("[DSL][$className] " . $message, $context);
    }

    /**
     * Returns the model's ID — used for serializing Process state
     */
    public function id(): ?int
    {
        return $this->model->getKey();
    }
}
