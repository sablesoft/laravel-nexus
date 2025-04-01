<?php

namespace App\Logic\Effect\Handlers;

use App\Events\RefreshPlay;
use App\Livewire\Chat\Play;
use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Process;
use App\Models\Screen;

class ChatRefreshHandler implements EffectHandlerContract
{
    public function __construct(protected null|array|bool $params = false) {}

    public function execute(Process $process): void
    {
        $codes = !empty($this->params)
            ? ValueResolver::resolve($this->params, $process)
            : null;
        $base = Play::CHANNELS_PREFIX .'.'. $process->chat->id();
        foreach ($this->getChannels($codes, $base) as $channel) {
            broadcast(new RefreshPlay($channel));
        }
    }

    protected function getChannels(?array $codes, string $base): array
    {
        $channels = [];
        if (!empty($codes)) {
            $screens = Screen::whereIn('code', $codes)->get();
            foreach ($screens as $screen) {
                $channels[] = $base .'.'. $screen->id;
            }
        } else {
            $channels[] = $base;
        }

        return $channels;
    }
}
