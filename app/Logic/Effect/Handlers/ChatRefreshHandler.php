<?php

namespace App\Logic\Effect\Handlers;

use App\Events\RefreshPlay;
use App\Livewire\Chat\Play;
use App\Logic\Contracts\EffectHandlerContract;
use App\Logic\Dsl\ValueResolver;
use App\Logic\Process;
use App\Models\Screen;

/**
 * Runtime handler for the `chat.refresh` effect.
 * Broadcasts a real-time refresh event to one or more screen-specific channels
 * associated with the current chat. Used to trigger UI updates for participants.
 *
 * If specific screen codes are provided, only those screens will be refreshed.
 * Otherwise, the refresh is sent to the base chat channel (affecting all screens).
 *
 * Environment:
 * - Registered via `EffectHandlerRegistry` under the key `"chat.refresh"`.
 * - Works with `ChatRefreshDefinition`, which defines allowed inputs.
 * - Uses Laravel's broadcasting system (Reverb) and `RefreshPlay` event.
 * - Dynamically resolves screen codes using `ValueResolver`.
 */
class ChatRefreshHandler implements EffectHandlerContract
{
    /**
     * @param null|array|string|bool $params Optional list of screen codes or false
     */
    public function __construct(protected null|array|bool $params = false) {}

    /**
     * Execute the refresh broadcast based on resolved screen codes.
     */
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

    /**
     * Resolve full channel names based on screen codes or fallback to chat base.
     *
     * @param array<string>|null $codes List of screen codes (optional)
     * @param string $base Chat channel prefix
     * @return array<int, string> List of fully qualified channel names
     */
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
