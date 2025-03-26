<?php

return [
    'is_enabled' => true,
    'components' => [
        'echo-presence'             => env('DEBUG_COMPONENT_ECHO_PRESENCE', false),
        'echo-public'               => env('DEBUG_COMPONENT_ECHO_PUBLIC', false),
        'flash'                     => env('DEBUG_COMPONENT_FLASH', false),
        'notification'              => env('DEBUG_COMPONENT_NOTIFICATION', false),
        'searchable'                => env('DEBUG_COMPONENT_SEARCHABLE', false),
        'searchable-multi-select'   => env('DEBUG_COMPONENT_SEARCHABLE_MULTI_SELECT', false),
        'searchable-select'         => env('DEBUG_COMPONENT_SEARCHABLE_SELECT', false),
        'uri'                       => env('DEBUG_COMPONENT_URI', false),
    ]
];
