<?php

namespace App\Logic\Effects;

use App\Logic\Contracts\EffectContract;
use App\logic\Process;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ValidateEffect implements EffectContract
{
    /**
     * @param array<string, mixed> $rules
     */
    public function __construct(protected array $rules) {}

    public function execute(Process $process): void
    {
        $validator = Validator::make($process->data(), $this->rules);

        if ($validator->fails()) {
            /** @noinspection PhpMultipleClassDeclarationsInspection */
            throw new ValidationException($validator);
        }
    }
}
