<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Route;

class Navlist extends Component
{
    public array $navlist;

    public function __construct()
    {
        $this->navlist = config('navlist');
    }

    public function render()
    {
        return view('components.navlist');
    }

    public static function registerRoutes(): void
    {
        foreach (config('navlist') as $group) {
            $prefix = $group['prefix'] ? $group['prefix'] . '.' : '';

            foreach ($group['items'] as $key => $item) {
                $routeName = $prefix . $key;
                $action = $item['action'] ?? null;
                $middleware = $item['middleware'] ?? null;
                if (!Route::has($routeName) && $action) {
                    Route::get(str_replace('.', '/', $routeName), $action)
                        ->name($routeName)
                        ->middleware($middleware);
                }
            }
        }
    }
}
