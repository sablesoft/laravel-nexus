<?php

return [
    'cache' => [
        'enabled' => env('DSL_CACHE', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Editor Format for Setup Fields
    |--------------------------------------------------------------------------
    |
    | This option controls the default format used to represent structured
    | configuration fields like "before" and "after" when editing them
    | via the UI. You may choose between "json" and "yaml" formats.
    |
    | This affects how the setup data is displayed to the user and how it
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
    'field_prefix' => ':',

    'screen_query' => '":type" == screen.code'
];
