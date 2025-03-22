<div class="flex flex-col h-full"
     x-data="{ typingUsers: {}, typingTimers: {} }"
     x-init="Echo.join('chats.play.{{ $chat->id }}')
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
    <!-- Main content container (chat + right sidebar) -->
    <div class="flex flex-1 overflow-hidden">
        <!-- Chat area -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Chat messages container -->
            <div class="flex-1 overflow-y-auto p-4 bg-white dark:bg-zinc-800">
                <div class="max-w-3xl mx-auto">
                    <!-- Chat messages -->
                    <div wire:loading.class="opacity-50">
                        {{-- TODO - ASC by time --}}
                        @foreach($chat->memories as $memory)
                            <div class="mb-4 p-3 rounded-lg shadow-sm
                                {{ $memory->member?->user_id === auth()->id() ? 'bg-blue-100 dark:bg-blue-900 self-end' : 'bg-gray-100 dark:bg-gray-700' }}">
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    <strong>{{ $memory->member?->mask_name ?? 'System' }}
                                        :</strong> {{ $memory->content }}
                                </p>
                                <span class="text-xs text-gray-400">{{ $memory->created_at->diffForHumans() }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Right sidebar -->
        <flux:sidebar position="right" sticky stashable
                      class="w-sm border-l border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 flex flex-col">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark"/>
            @php
                $sidebarStyle = $screen->imagePath ? "background-image: url('".Storage::url($screen->imagePath)."');".
                                       " background-size: cover; background-position: center;" : '';
            @endphp
            <div class="flex-1 overflow-y-auto space-y-4" style="{{ $sidebarStyle }}">
                <h1 class="text-center my-2 p-2 text-xl font-bold text-white bg-black/50 shadow-md">
                    {{ $screen->title }}
                </h1>
                <!-- Online members -->
                @if($onlineMembers->count())
                <h3 class="bg-black/50 pr-2 text-right text-lg font-semibold text-green-400">{{ __('Online') }}</h3>
                <ul class="space-y-2">
                    @foreach($onlineMembers as $member)
                        @php $isCurrentUser = $member->user_id === auth()->id(); @endphp
                        <li class="flex items-center gap-2 justify-end">
                            <span class="w-3 text-gray-500 dark:text-gray-400 text-sm relative top-[-15px] right-[2px]">
                                <template x-if="typingUsers[{{ $member->user_id }}]">
                                    <flux:icon name="chat-bubble-oval-left-ellipsis"
                                               class="animate-pulse scale-x-[-1]"/>
                                </template>
                                <template x-if="!typingUsers[{{ $member->user_id }}]">
                                    <flux:icon name="chat-bubble-oval-left-ellipsis"
                                               class="invisible scale-x-[-1]"/>
                                </template>
                            </span>
                            <flux:profile class="pr-2 bg-black/50 dark:bg-black/50 !dark:hover:bg-black/50 !hover:bg-black/50 rounded-r-none {{ $isCurrentUser ? 'border-2 border-green-400 shadow-lg' : 'cursor-pointer' }}"
                                          :chevron="false" :name="$member->mask_name"
                                          :avatar="Storage::url($member->mask->imagePath)" />
                        </li>
                    @endforeach
                </ul>
                @endif

                <!-- Offline members -->
                @if($offlineMembers->count())
                <h3 class="bg-black/50 pr-2 text-right text-lg font-semibold text-gray-400 mt-6">{{ __('Offline') }}</h3>
                <ul class="space-y-2">
                    @foreach($offlineMembers as $member)
                        <li class="flex items-center gap-2 justify-end">
                            <flux:profile class="bg-black/50 dark:bg-black/50 !dark:hover:bg-black/50 !hover:bg-black/50 pr-2 rounded-r-none" :chevron="false" :name="$member->mask_name"
                                          :avatar="Storage::url($member->mask->imagePath)" />
                        </li>
                    @endforeach
                </ul>
                @endif
            </div>
        </flux:sidebar>
    </div>

    <!-- TODO: Control panel -->
    <div class="p-4 bg-zinc-100 dark:bg-zinc-900 border-t border-zinc-300 dark:border-zinc-700 flex items-center gap-2 w-full">
        <flux:button wire:click="test" class="cursor-pointer">
            Test 1
        </flux:button>
        <flux:button wire:click="test2" class="cursor-pointer">
            Test 2
        </flux:button>
        <flux:input wire:model.defer="message" placeholder="Type your message..." class="flex-1"
                    wire:keydown.enter="sendMessage"
                    x-on:input.debounce.500ms="
                    Echo.join('chats.play.{{ $chat->id }}')
                        .whisper('typing', { userId: {{ auth()->id() }} });"/>
    </div>

    <x-echo-presence channel="chats.play.{{ $chat->id }}"/>
</div>
