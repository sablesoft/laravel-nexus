<?php

namespace App\View\Components;

use Closure;
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
                $action = static::prepareAction($item['action'] ?? null);
                $middleware = $item['middleware'] ?? null;
                $uri = $item['uri'] ?? str_replace('.', '/', $routeName);
                if (!Route::has($routeName) && $action) {
                    Route::get($uri, $action)->name($routeName)->middleware($middleware);
                }
                $routes = $item['routes'] ?? [];
                foreach ($routes as $k => $route) {
                    $method = $route['method'] ?? 'get';
                    $action = static::prepareAction($route['action'] ?? null);
                    $routeName = $prefix . $k;
                    $uri = $route['uri'] ?? str_replace('.', '/', $routeName);
                    if (!Route::has($routeName) && $action) {
                        Route::$method($uri, $action)->name($routeName)->middleware($middleware);
                    }
                }
            }
        }
    }

    protected static function prepareAction(?string $action): string|Closure|null
    {
        return (!$action || class_exists($action)) ? $action : fn() => view($action);
    }
}
