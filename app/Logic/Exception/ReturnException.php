<?php

namespace App\Logic\Exception;

use Exception;

/**
 * Special control-flow exception to interrupt logic execution.
 * Used internally by the `return` DSL effect.
 */
class ReturnException extends Exception
{
    public function __construct(
        protected bool $fullReturn = true
    ) {
        parent::__construct('Logic execution interrupted by return');
    }

    public function isFullReturn(): bool
    {
        return $this->fullReturn;
    }
}
