<?php

namespace App\Logic\Exception;

use Exception;

/**
 * Special control-flow exception to interrupt logic execution and return a value.
 * Used internally by the `return` DSL effect.
 */
class ReturnException extends Exception
{
    public function __construct(
        protected mixed $value = null
    ) {
        parent::__construct('Logic execution interrupted by return');
    }

    public function getValue(): mixed
    {
        return $this->value;
    }
}
