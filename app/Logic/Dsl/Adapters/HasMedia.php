<?php

namespace App\Logic\Dsl\Adapters;

use App\Logic\Dsl\ValueResolver;
use App\Logic\Facades\Dsl;

trait HasMedia
{
    public function note(string $code): ?string
    {
        $this->log('Note', ['code' => $code]);
        $content = $this->model->note($code)?->content;
        if ($content) {
            $content = ValueResolver::resolve(Dsl::prefixed($content), $this->process->toContext());
        }

        return $content;
    }
}
