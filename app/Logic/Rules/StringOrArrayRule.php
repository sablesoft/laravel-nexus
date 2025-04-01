<?php

namespace App\Logic\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;

class StringOrArrayRule implements ValidationRule
{
    public function __construct(protected array $rules = []) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_string($value)) {
            return;
        }

        if (!is_array($value)) {
            $fail("The {$attribute} field must be a string (DSL) or an array (literal).");
            return;
        }

        if (empty($this->rules)) {
            return;
        }

        $data = array_is_list($value) ? ['value' => $value] : $value;

        $validator = Validator::make($data, $this->rules);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                $fail($message);
            }
        }
    }
}
