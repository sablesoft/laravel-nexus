<div class="space-y-4">
    @php /** @var \App\Models\Transfer $transfer */ @endphp
    @foreach($transfers as $transfer)
        <div x-data="{ open: false }">
            <div class="flex items-center justify-between p-2 cursor-pointer border bg-zinc-100 dark:bg-zinc-900 border-zinc-200 dark:border-zinc-700 shadow-lg rounded-lg"
                 @click="open = !open">
                <div class="flex items-center space-x-2">
                    @php $imagePath = $transfer->screenTo?->imagePath @endphp
                    <div class="w-20 h-20 rounded-lg overflow-hidden mr-5">
                        <x-image-viewer :path="$imagePath"/>
                    </div>
                    <flux:heading size="lg" class="font-semibold">
                        {{ $transfer->screenTo?->title }}
                    </flux:heading>
                </div>
                <span x-text="open ? '▲' : '▼'"></span>
            </div>

            <div x-show="open" class="mt-2 p-2 border bg-zinc-100 dark:bg-zinc-900 border-zinc-200 dark:border-zinc-700 shadow-lg rounded-lg">
                <div class="mb-2">
                    <label class="block text-sm font-medium">Title</label>
                    <p>{{ $transfer->title ?: '—' }}</p>
                </div>

                <div class="mb-2">
                    <label class="block text-sm font-medium">Tooltip</label>
                    <p>{{ $transfer->tooltip ?? '—' }}</p>
                </div>

                <div class="mb-2">
                    <label class="block text-sm font-medium">Active (JSON)</label>
                    <pre class="p-2 rounded text-sm overflow-auto">
                        {{ $transfer->active ?? '—' }}
                    </pre>
                </div>
            </div>
        </div>
    @endforeach
</div>
