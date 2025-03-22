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
                'action' => 'dashboard',
                'middleware' => ['auth'],
                'tooltip' => 'Main page'
            ],
            'heroes' => [ // route and uri key
                'icon' => 'user-group',
                'title' => 'Heroes',
                'action' => \App\Livewire\Hero::class,
                'middleware' => ['auth', 'verified'],
                'tooltip' => 'Our stories in faces'
            ],
            'catalog' => [
                'icon' => 'book-open',
                'title' => 'Catalog',
                'action' => \App\Livewire\Catalog::class,
                'middleware' => ['auth', 'verified'],
                'tooltip' => 'What do you want to try today?'
            ],
            'chats' => [
                'icon' => 'chat-bubble-left-ellipsis',
                'title' => 'Chats',
                'action' => \App\Livewire\Chat\Index::class,
                'middleware' => ['auth', 'verified'],
                'tooltip' => 'Time to chat!',
                'routes' => [
                    'chats.view' => [
                        'uri' => 'chats/view/{id}',
                        'action' => \App\Livewire\Chat\View::class,
                    ],
                    'chats.edit' => [
                        'uri' => 'chats/edit/{id}',
                        'action' => \App\Livewire\Chat\Edit::class,
                    ],
                    'chats.play' => [
                        'uri' => 'chats/play/{id}',
                        'action' => \App\Livewire\Chat\Play::class,
                    ]
                ]
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
                'is_crud' => true,
                'action' => \App\Livewire\Workshop\Image::class,
                'middleware' => ['auth', 'verified'],
                'tooltip' => 'Manage your images!'
            ],
            'masks' => [
                'icon' => 'identification',
                'title' => 'Masks',
                'is_crud' => true,
                'action' => \App\Livewire\Workshop\Mask::class,
                'middleware' => ['auth', 'verified'],
                'tooltip' => 'Manage your masks!'
            ],
            'applications' => [
                'icon' => 'server-stack',
                'title' => 'Applications',
                'is_crud' => true,
                'action' => \App\Livewire\Workshop\Application::class,
                'middleware' => ['auth', 'verified'],
                'tooltip' => 'Build your apps!'
            ],
            'screens' => [
                'icon' => 'window',
                'title' => 'Screens',
                'is_crud' => true,
                'action' => \App\Livewire\Workshop\Screen::class,
                'middleware' => ['auth', 'verified'],
                'tooltip' => 'Build screens for your apps'
            ],
            'scenarios' => [
                'icon' => 'puzzle-piece',
                'title' => 'Scenarios',
                'is_crud' => true,
                'action' => \App\Livewire\Workshop\Scenario::class,
                'middleware' => ['auth', 'verified'],
                'tooltip' => 'Build scenarios for your screens'
            ]
        ]
    ]
];
