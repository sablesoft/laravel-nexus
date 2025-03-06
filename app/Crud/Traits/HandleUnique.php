<?php

namespace App\Crud\Traits;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

trait HandleUnique
{
    /**
     * @param string $table
     * @param string $column
     * @return Unique
     */
    public function uniqueRule(string $table, string $column): Unique
    {
        return $this->modelId ?
            Rule::unique($table, $column)->ignore($this->modelId) :
            Rule::unique($table, $column);
    }
}
