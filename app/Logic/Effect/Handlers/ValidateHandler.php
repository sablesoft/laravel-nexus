<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Process;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Runtime handler for the `validate` effect.
 * Applies a set of validation rules to the current process data.
 * If any rule fails, execution is halted by throwing a `ValidationException`.
 *
 * Context:
 * - Registered under the DSL key `"validate"` in the EffectHandlerRegistry.
 * - Associated with `ValidateDefinition`, which restricts allowed rule types.
 * - Commonly used to enforce structure and input expectations before critical logic.
 *
 * Behavior:
 * - Rules are written in standard Laravel format (`required|string|min:3`, etc.).
 * - Validation is strict: failure immediately halts logic.
 * - Uses `$process->data()` as the validation input.
 */
class ValidateHandler implements EffectHandlerContract
{
    /**
     * @param array<string, mixed> $rules Set of Laravel validation rules to apply
     */
    public function __construct(protected array $rules) {}

    public function describeLog(Process $process): ?string
    {
        $fields = array_keys($this->rules);
        return 'Validated fields: ' . implode(', ', $fields);
    }

    /**
     * Execute the validation against process data.
     *
     * @throws ValidationException If any rule fails
     */
    public function execute(Process $process): void
    {
        $validator = Validator::make($process->data(), $this->rules);

        if ($validator->fails()) {
            /** @noinspection PhpMultipleClassDeclarationsInspection */
            throw new ValidationException($validator);
        }
    }
}
