<?php

namespace App\Crud\Traits;

use App\View\Components\Navlist;

trait HandleURI
{
    abstract public static function routeName(): string;

    protected function changeUri(?string $action = null, ?int $id = null): void
    {
        $uri = '/'. Navlist::baseUri(static::routeName());
        if ($action) {
            $uri .= '/'. $action;
        }
        if ($action && $id) {
            $uri .= '/'. $id;
        }
        if (!$action && $id) {
            $message = '[URI][Changing] Wrong data - id without action! URI: '. $uri;
            $this->dispatch('debug', message: $message, level: 'error');
            return;
        }

        $this->dispatch('uri', uri: $uri);
    }
}
