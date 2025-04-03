<?php

namespace App\Logic\Effect\Handlers;

use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Process;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Runtime handler for the `validate` effect.
 * Applies Laravel-style validation rules to the current process data.
 * Throws a `ValidationException` if any rule fails, effectively interrupting
 * the scenario execution with an error.
 *
 * Context:
 * - Instantiated by `EffectHandlerRegistry` when resolving the `"validate"` effect.
 * - Works in conjunction with `ValidateDefinition`, which restricts allowed rules.
 * - Uses `$process->data()` as input source for validation.
 */
class ValidateHandler implements EffectHandlerContract
{
    /**
     * @param array<string, mixed> $rules Set of Laravel validation rules to apply
     */
    public function __construct(protected array $rules) {}

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
