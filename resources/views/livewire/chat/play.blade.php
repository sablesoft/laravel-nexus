<div class="flex flex-col h-full max-h-dvh"
     x-data="{ typingUsers: {}, typingTimers: {} }"
     x-init="Echo.join('{{ $channelsPrefix }}.{{ $chat->id }}.{{ $screen->id }}')
                .listenForWhisper('typing', (e) => {
                    console.debug('[Typing]', e.userId);
                    if (typingTimers[e.userId]) {
                        clearTimeout(typingTimers[e.userId]);
                    }
                    typingUsers[e.userId] = true;
                    typingTimers[e.userId] = setTimeout(() => {
                        delete typingUsers[e.userId];
                        delete typingTimers[e.userId];
                    }, 2000);
                });">

    <header id="chat-header"
         class="bg-zinc-100 border-b border-zinc-300 dark:bg-zinc-900 dark:border-zinc-700 flex font-black justify-center p-2 text-xl w-full">
        <h1>{{ $chat->title }}</h1>
    </header>

    <!-- Main content container (chat + right sidebar) -->
    <div id="chat-main" class="flex flex-1 overflow-hidden">
        <!-- Chat area -->
        <div id="chat-content" class="flex flex-col flex-1 overflow-hidden h-full">
            <!-- Chat messages container -->
            <div class="flex-1 overflow-y-auto p-4 bg-white dark:bg-zinc-800">
                <div class="max-w-3xl mx-auto">
                    <!-- Chat messages -->
                    <div wire:loading.class="opacity-50 min-h-0">
                        @foreach($memories as $memory)
                            <div class="mb-4 p-3 rounded-lg shadow-sm
                                {{ $memory['user_id'] === auth()->id() ? 'bg-blue-100 dark:bg-blue-900 self-end' : 'bg-gray-100 dark:bg-gray-700' }}">
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    <strong>{{ $memory['mask_name'] ?: 'System' }}:</strong> {!! nl2br(e($memory['content'])) !!}
                                </p>
                                @if(config('app.debug'))
                                    @php
                                        $data = ['type' => $memory['type']];
                                        $meta = $memory['meta'];
                                        $act = $meta['act'] ?? [];
                                        unset($meta['act']);
                                        $desiredOrder = ['do', 'what', 'using', 'from', 'to', 'for', 'how'];
                                        $reorderedAct = collect($desiredOrder)
                                            ->filter(fn($key) => array_key_exists($key, $act))
                                            ->mapWithKeys(fn($key) => [$key => $act[$key]])
                                            ->toArray();
                                    @endphp
                                    @if($reorderedAct)
                                        @php $data['act'] = $reorderedAct; @endphp
                                    @endif
                                    @if($meta)
                                        @php $data['meta'] = $meta; @endphp
                                    @endif
                                    @php $data = json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE); @endphp

                                    <div x-data="{ open: false }" class="mt-2">
                                        <button @click="open = !open"
                                                class="text-xs text-blue-500 hover:underline flex items-center space-x-1">
                                            <span x-show="!open">▶</span>
                                            <span x-show="open">▼</span>
                                            <span>{{ __('Details') }}</span>
                                        </button>

                                        <div x-show="open" x-transition class="mt-2 space-y-2">
                                                <x-code-mirror wire:key="codemirror-debug-{{ $memory['id'] }}"
                                                               lang="json"
                                                               :readonly="true"
                                                               :content="$data"
                                                               class="w-full" />
                                        </div>
                                    </div>
                                @endif

                                <span class="text-xs text-gray-400">{{ ($memory['created_at'])->diffForHumans() }}</span>
                            </div>
                        @endforeach
                        @if($waiting)
                            <div class="mb-4 p-3 rounded-lg shadow-sm bg-gray-200 dark:bg-gray-700 self-start animate-pulse">
                                <p class="text-sm text-gray-600 dark:text-gray-300 italic">...</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Right sidebar -->
        <flux:sidebar id="chat-sidebar" position="right" sticky stashable
                      class="p-1! w-xs border-l border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 flex flex-col">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark"/>
            @php
                $sidebarStyle = $screen->imagePathMd ? "background-image: url('".Storage::url($screen->imagePathMd)."');".
                                       " background-size: cover; background-position: center;" : '';
            @endphp
            <div class="flex-1 overflow-y-auto space-y-4" style="{{ $sidebarStyle }}">
                <h2 class="bg-gray-100/50 dark:bg-black/50 dark:text-white font-bold my-2 p-2 shadow-md text-center text-xl">
                    {{ $screen->title }}
                </h2>
                <!-- Online characters -->
                @if($onlineCharacters->count())
                    <h3 class="bg-gray-100/50 dark:bg-black/50 pr-2 text-right text-lg font-semibold text-green-400">{{ __('Online') }}</h3>
                    <ul class="space-y-2">
                        @foreach($onlineCharacters as $character)
                            @php $isCurrentUser = $character->user_id === auth()->id(); @endphp
                            <li class="flex items-center gap-2 justify-end">
                            <span class="w-3 text-gray-500 dark:text-gray-400 text-sm relative top-[-15px] right-[2px]">
                                <template x-if="typingUsers[{{ $character->user_id }}]">
                                    <flux:icon name="chat-bubble-oval-left-ellipsis"
                                               class="animate-pulse scale-x-[-1]"/>
                                </template>
                                <template x-if="!typingUsers[{{ $character->user_id }}]">
                                    <flux:icon name="chat-bubble-oval-left-ellipsis"
                                               class="invisible scale-x-[-1]"/>
                                </template>
                            </span>
                                <flux:profile
                                    class="pr-2 bg-gray-100/50 dark:bg-black/50 !dark:hover:bg-black/50 !hover:bg-gray-100/50 rounded-r-none {{ $isCurrentUser ? 'border-2 border-green-400 shadow-lg' : 'cursor-pointer' }}"
                                    :chevron="false" :name="$character->maskName"
                                    :avatar="Storage::url($character->mask->imagePathSm)"/>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <!-- Offline characters -->
                @if($offlineCharacters->count())
                    <h3 class="bg-black/50 pr-2 text-right text-lg font-semibold mt-6">{{ __('Offline') }}</h3>
                    <ul class="space-y-2">
                        @foreach($offlineCharacters as $character)
                            <li class="flex items-center gap-2 justify-end">
                                <flux:profile
                                    class="bg-black/50 dark:bg-black/50 !dark:hover:bg-black/50 !hover:bg-black/50 pr-2 rounded-r-none"
                                    :chevron="false" :name="$character->maskName"
                                    :avatar="Storage::url($character->mask->imagePathSm)"/>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </flux:sidebar>
    </div>

    <footer id="chat-control"
        class="select-none p-3 bg-zinc-100 dark:bg-zinc-900 border-t border-zinc-300 dark:border-zinc-700 flex items-center gap-2 w-full">
        {{-- Transfers --}}
        @foreach($transfers as $transfer)
            @if($transfer['tooltip'])
                <flux:tooltip :content="$transfer['tooltip']">
                    <flux:button wire:click="transfer({{ $transfer['id'] }})"
                        :disabled="!$transfer['enabled']"
                        class="cursor-pointer">
                        {{ $transfer['title'] }}
                    </flux:button>
                </flux:tooltip>
            @else
                <flux:button wire:click="transfer({{ $transfer['id'] }})"
                    :disabled="!$transfer['enabled']"
                    class="cursor-pointer">
                    {{ $transfer['title'] }}
                </flux:button>
            @endif
        @endforeach

        {{-- Actions --}}
        @foreach($actions as $action)
            @if($action['tooltip'])
                <flux:tooltip :content="$action['tooltip']">
                    <flux:button variant="filled" wire:click="action({{ $action['id'] }})"
                        :disabled="!$action['enabled']"
                        class="cursor-pointer">
                        {{ $action['title'] }}
                    </flux:button>
                </flux:tooltip>
            @else
                <flux:button variant="filled" wire:click="action({{ $action['id'] }})"
                    :disabled="!$action['enabled']"
                    class="cursor-pointer">
                    {{ $action['title'] }}
                </flux:button>
            @endif
        @endforeach

        {{-- Inputs --}}
        @if(count($inputs))
            <flux:input.group>
                <flux:dropdown>
                    <flux:button class="{{ count($inputs) > 1 ? 'cursor-pointer' : '' }}"
                                 :icon-trailing="count($inputs) > 1 ? 'chevron-down' : ''"
                                 :disabled="count($inputs) === 1">
                        {{ $activeInput['title'] }}
                    </flux:button>
                    <flux:menu>
                        @foreach($inputs as $input)
                            @if($input['id'] !== $activeInput['id'])
                            <flux:menu.item wire:click="changeInput({{ $input['id'] }})"
                                            :disabled="!$input['enabled']">
                                {{ $input['title'] }}
                            </flux:menu.item>
                            @endif
                        @endforeach
                    </flux:menu>
                </flux:dropdown>
                <flux:input wire:model.defer="ask"
                            placeholder="{{ $activeInput['tooltip'] ?: '' }}" class="flex-1"
                            wire:keydown.enter="input"
                            :disabled="!$activeInput['enabled']"
                            x-on:input.debounce.500ms="
                    Echo.join('{{ $channelsPrefix }}.{{ $chat->id }}.{{ $screen->id }}')
                        .whisper('typing', { userId: {{ auth()->id() }} });"/>
            </flux:input.group>
        @endif
    </footer>

    <x-echo-presence :channels="$presence"/>
</div>
