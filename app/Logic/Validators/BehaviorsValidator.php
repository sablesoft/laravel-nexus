<?php

namespace App\Logic\Validators;

use App\Logic\Contracts\DslValidatorContract;
use InvalidArgumentException;

class BehaviorsValidator implements DslValidatorContract
{

    public static function validate(array $dsl): void
    {
        if (empty($dsl)) {
            return;
        }
        if (!isset($dsl['can'])) {
            throw new InvalidArgumentException("Behaviors should contain 'can' root");
        }
        $behaviors = $dsl['can'];
        if (array_is_list($behaviors)) {
            throw new InvalidArgumentException("Behaviors should be an associative array");
        }
        foreach ($behaviors as $name => $behavior) {
            if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_.]*$/', $name)) {
                throw new InvalidArgumentException("The behavior name must be a valid variable name: " . $name);
            }
            if (!is_string($behavior) && !is_bool($behavior)) {
                throw new InvalidArgumentException("Behavior value should be expression string or boolean");
            }
        }
    }
}
