<div class="flex flex-col h-full">
    <!-- Main content container (chat + right sidebar) -->
    <div class="flex flex-1 overflow-hidden">
        <!-- Chat area -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Chat messages container -->
            <div class="flex-1 overflow-y-auto p-4 bg-white dark:bg-zinc-800">
                <div class="max-w-3xl mx-auto">
                    <!-- Chat messages -->
                    <div wire:loading.class="opacity-50">
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
                      class="border-l border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 flex flex-col">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark"/>

            <div class="flex-1 overflow-y-auto space-y-4">
                <!-- Online members -->
                @if($onlineMembers->count())
                <h3 class="text-lg font-semibold text-green-600 dark:text-green-400">{{ __('Online') }}</h3>
                <ul class="space-y-2">
                    @foreach($onlineMembers as $member)
                        <li class="flex items-center gap-2">
                            <img src="{{ Storage::url($member->mask->imagePath) }}"
                                 alt="{{ $member->mask_name }}" class="h-8 w-8 rounded-full">
                            <span class="text-green-600 dark:text-green-400">{{ $member->mask_name }}</span>
                        </li>
                    @endforeach
                </ul>
                @endif

                <!-- Offline members -->
                @if($offlineMembers->count())
                <h3 class="text-lg font-semibold text-gray-500 dark:text-gray-400 mt-6">{{ __('Offline') }}</h3>
                <ul class="space-y-2">
                    @foreach($offlineMembers as $member)
                        <li class="flex items-center gap-2">
                            <img src="{{ Storage::url($member->mask->imagePath) }}"
                                 alt="{{ $member->mask_name }}" class="h-8 w-8 rounded-full opacity-50">
                            <span class="text-gray-500 dark:text-gray-400">{{ $member->mask_name }}</span>
                        </li>
                    @endforeach
                </ul>
                @endif
            </div>
        </flux:sidebar>
    </div>

    <!-- Control panel -->
    <div
        class="p-4 bg-zinc-100 dark:bg-zinc-900 border-t border-zinc-300 dark:border-zinc-700 flex items-center gap-2 w-full">
        <flux:input wire:model.defer="message" placeholder="Type your message..." class="flex-1"/>
        <flux:button wire:click="sendMessage" variant="primary" icon="paper-airplane" class="cursor-pointer">
            Send
        </flux:button>
    </div>
    @script
    <script>
        let initPresence = function (chatId) {
            let channelName = `play.${chatId}`;
            console.debug('Join presence', channelName);
            Echo.join(channelName)
                .here((users) => {
                    console.debug('[Play][Here]', users);
                    $wire.dispatchSelf('usersHere', {members: users});
                }).joining((user) => {
                console.debug('[Play][Joining]', user.id);
                $wire.dispatchSelf('userJoining', {id: user.id});
            }).leaving((user) => {
                console.debug('[Play][Leaving]', user.id);
                $wire.dispatchSelf('userLeaving', {id: user.id});
            }).error((error) => {
                console.error(error);
            });
        }
        let playNavigate = function(chatId) {
            console.debug(`[Play][Navigate] Leaving chat ${chatId}`);
            Echo.leave(`play.${chatId}`);
        }
        document.addEventListener("livewire:navigate", function () {
            playNavigate({{ $chat->id }});
        });
        initPresence({{ $chat->id }});
    </script>
    @endscript
</div>
