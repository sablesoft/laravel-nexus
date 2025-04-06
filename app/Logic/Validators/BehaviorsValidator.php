<?php

namespace App\Logic\Validators;

use App\Logic\Contracts\DslValidatorContract;
use InvalidArgumentException;

class BehaviorsValidator implements DslValidatorContract
{
    public static function validate(?array $dsl): void
    {
        if (empty($dsl)) {
            return;
        }

        if (!array_key_exists('can', $dsl)) {
            throw new InvalidArgumentException("Behaviors must contain a 'can' root block.");
        }

        $behaviors = $dsl['can'];
        if (!is_array($behaviors) || array_is_list($behaviors)) {
            throw new InvalidArgumentException("The 'can' block must be an associative array.");
        }

        foreach ($behaviors as $name => $value) {
            if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_.]*$/', $name)) {
                throw new InvalidArgumentException("Invalid behavior name: '{$name}'. Use variable-like keys.");
            }
            if (!is_string($value) && !is_bool($value)) {
                throw new InvalidArgumentException("Behavior '{$name}' must be a boolean or an expression string.");
            }
        }
    }
}
