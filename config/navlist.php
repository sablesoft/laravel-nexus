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
            'heroes' => [ // route and uri key
                'icon' => 'user-group',
                'title' => 'Heroes',
                'action' => \App\Livewire\Settings\Profile::class,
                'middleware' => ['auth', 'verified'],
                'tooltip' => 'Our stories in faces'
            ],
            'play' => [
                'icon' => 'play',
                'title' => 'Play',
                'action' => \App\Livewire\Settings\Profile::class,
                'middleware' => ['auth', 'verified'],
                'tooltip' => 'What do you want to try today?'
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
            'images' => [
                'icon' => 'photo',
                'title' => 'Images',
                'action' => \App\Livewire\Workshop\Image::class,
                'middleware' => ['auth', 'verified'],
                'tooltip' => 'Manage your images!'
            ],
            'masks' => [
                'icon' => 'identification',
                'title' => 'Masks',
                'action' => \App\Livewire\Workshop\Mask::class,
                'middleware' => ['auth', 'verified'],
                'tooltip' => 'Manage your masks!'
            ],
            'applications' => [
                'icon' => 'server-stack',
                'title' => 'Applications',
                'action' => \App\Livewire\Workshop\Application::class,
                'middleware' => ['auth', 'verified'],
                'tooltip' => 'Build your apps!'
            ],
            'screens' => [
                'icon' => 'window',
                'title' => 'Screens',
                'action' => \App\Livewire\Workshop\Screen::class,
                'middleware' => ['auth', 'verified'],
                'tooltip' => 'Build screens for your apps'
            ],
            'scenarios' => [
                'icon' => 'puzzle-piece',
                'title' => 'Scenarios',
                'action' => \App\Livewire\Workshop\Scenario::class,
                'middleware' => ['auth', 'verified'],
                'tooltip' => 'Build scenarios for your screens'
            ]
        ]
    ]
];
