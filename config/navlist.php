<?php

return [
    // navlist.group platform
    'platform' => [
        'heading' => 'Platform',
        'prefix' => null, // route and uri prefix
        'items' => [
            'dashboard' => [ // route and uri key
                'icon' => 'home',
                'title' => 'Dashboard',
                'action' => fn() => view('dashboard'),
                'middleware' => ['auth'],
                'tooltip' => 'Main page'
            ],
            'community' => [ // route and uri key
                'icon' => 'globe-alt',
                'title' => 'Community',
                'action' => \App\Livewire\Settings\Profile::class,
                'middleware' => ['auth', 'verified'],
                'tooltip' => 'Find yourself some friends!'
            ],
            'applications' => [
                'icon' => 'play',
                'title' => 'Applications',
                'action' => \App\Livewire\Settings\Profile::class,
                'middleware' => ['auth', 'verified'],
                'tooltip' => 'What you want to try today?'
            ],
            'chats' => [
                'icon' => 'chat-bubble-left-ellipsis',
                'title' => 'Chats',
                'action' => \App\Livewire\Settings\Profile::class,
                'middleware' => ['auth', 'verified'],
                'tooltip' => 'Time to chat!'
            ],
        ]
    ],

    // navlist.group workshop
    'workshop' => [
        'heading' => 'Workshop',
        'prefix' => 'workshop', // route and uri prefix
        'items' => [
            'applications' => [
                'icon' => 'home',
                'title' => 'Applications',
                'action' => \App\Livewire\Settings\Profile::class,
                'middleware' => ['auth', 'verified'],
                'tooltip' => 'Build your apps!'
            ],
            'screens' => [
                'icon' => 'window',
                'title' => 'Screens',
                'action' => \App\Livewire\Settings\Profile::class,
                'middleware' => ['auth', 'verified'],
                'tooltip' => 'Build screens for your apps'
            ],
            'scenarios' => [
                'icon' => 'puzzle-piece',
                'title' => 'Scenarios',
                'action' => \App\Livewire\Settings\Profile::class,
                'middleware' => ['auth', 'verified'],
                'tooltip' => 'Build scenarios for your screens'
            ]
        ]
    ]
];
