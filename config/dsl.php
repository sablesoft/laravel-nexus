<?php

return [
    'cache' => [
        'enabled' => env('DSL_CACHE', false),
    ],

    'debug' => [
        'disabled' => env('DSL_DEBUG_DISABLED', false),
        'process' => env('DSL_DEBUG_PROCESS', false),
        'adapter' => env('DSL_DEBUG_ADAPTER', false),
        'query' => env('DSL_DEBUG_QUERY', false),
        'effect' => env('DSL_DEBUG_EFFECT', false),
        'memory' => env('DSL_DEBUG_MEMORY', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Editor Format for Effects Fields
    |--------------------------------------------------------------------------
    |
    | This option controls the default format used to represent structured
    | configuration fields like "before" and "after" when editing them
    | via the UI. You may choose between "json" and "yaml" formats.
    |
    | This affects how the effects data is displayed to the user and how it
    | should be parsed when submitted back to the server.
    |
    | Supported: "json", "yaml"
    |
    */
    'editor' => env('DSL_EDITOR', 'json'),


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
    'field_prefix' => env('DSL_FIELD_PREFIX', ':'),

    /*
    |--------------------------------------------------------------------------
    | String Literal Prefix for Expression Evaluation
    |--------------------------------------------------------------------------
    |
    | This prefix is used to distinguish plain string literals from DSL expressions.
    | When a string starts with this prefix, it will be treated as a raw string
    | and not evaluated as an expression. This is useful when the string contains
    | characters that would otherwise be interpreted as part of the DSL syntax,
    | such as variable names or math operators.
    |
    | For example:
    |   ">>Hello, {{name}}"   => Interpreted as a string with template interpolation
    |   ">>user.score"        => Interpreted as a plain string, not as a variable
    |   "user.score"          => Interpreted as a DSL expression and evaluated
    |
    | Supported values: any short, YAML-safe prefix (e.g. ">>", "::", "^")
    |
    */
    'string_prefix' => env('DSL_STRING_PREFIX', \App\Logic\Dsl\ValueResolver::DEFAULT_STRING_PREFIX),

    'raw_prefix' => env('DSL_RAW_PREFIX', \App\Logic\Dsl\ValueResolver::DEFAULT_RAW_PREFIX),

    'screen_query' => '":type" == screen.code'
];
