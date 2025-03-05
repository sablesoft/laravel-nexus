<flux:navlist variant="outline">
    @foreach ($navlist as $groupKey => $group)
        <flux:navlist.group heading="{{ __($group['heading']) }}" class="grid">
            @foreach ($group['items'] as $key => $item)
                @php
                    $hide = false;
                    $routeName = $group['prefix'] ? $group['prefix'] . '.' . $key : $key;
                    $middleware = $item['middleware'] ?? [];
                    if (in_array('verified', $middleware)) {
                        $hide = !auth()->user()->hasVerifiedEmail();
                    }
                @endphp
                @if($hide)
                    <flux:tooltip position="right">
                        <div>
                            <flux:button icon="{{ $item['icon'] }}" variant="ghost" disabled>
                                {{ __($item['title']) }}
                            </flux:button>
                        </div>
                        <flux:tooltip.content>
                            <p>{{ __('You need to verify your email!') }}</p>
                        </flux:tooltip.content>
                    </flux:tooltip>
                @else
                    <flux:tooltip position="right">
                        <flux:navlist.item icon="{{ $item['icon'] }}"
                                           :href="route($routeName)"
                                           :current="request()->routeIs($routeName)"
                                           wire:navigate>
                            {{ __($item['title']) }}
                        </flux:navlist.item>
                        <flux:tooltip.content>
                            <p>{{ __($item['tooltip']) }}</p>
                        </flux:tooltip.content>
                    </flux:tooltip>
                @endif

            @endforeach
        </flux:navlist.group>
    @endforeach
</flux:navlist>
