<?php

return [
    'cache' => [
        'enabled' => env('DSL_CACHE', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Field Prefix for DSL Query Syntax
    |--------------------------------------------------------------------------
    |
    | When parsing expressions in the DSL, string values starting with this
    | prefix will be interpreted as field names (columns or json paths),
    | instead of string constants or context variables.
    |
    | Example: ":type" => field "type"
    |
    */
    'field_prefix' => ':',
    'screen_query' => '":type" == screen.code'
];
