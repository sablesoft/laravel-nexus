<?php

namespace App\Logic\Rules;

use Illuminate\Support\Facades\Validator;

trait ArrayTrait
{
    protected function validateArray(string $attribute, mixed $value, \Closure $fail, bool $required = true): void
    {
        if (!is_array($value)) {
            if ($required) {
                $fail("The {$attribute} field must be a variable or an array (literal).");
            }
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
