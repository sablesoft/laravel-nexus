<div class="space-y-2">
    @php /** @var \App\Models\Transfer $transfer */ @endphp

    @if($transfers->count())
        {{-- Table header --}}
        <div class="grid grid-cols-4 gap-4 font-bold text-sm text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-md px-4 py-2">
            <span>Screen</span>
            <span>Title</span>
            <span>Tooltip</span>
            <span class="text-right">Details</span>
        </div>
    @endif

    @foreach($transfers as $transfer)
        @php $imagePath = $transfer->screenTo?->imagePathMd; @endphp

        <div x-data="{ open: false }" class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-md shadow transition-all duration-300">
            {{-- Row --}}
            <div
                class="grid grid-cols-4 gap-4 items-center px-4 py-3 cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700"
                @click="open = !open"
            >
                {{-- Screen (image + title) --}}
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded overflow-hidden">
                        <x-image-viewer :path="$imagePath"/>
                    </div>
                    <a href="{{ route('workshop.screens', ['action' => 'view', 'id' => $transfer->screen_to_id ]) }}"
                       wire:click.stop wire:navigate
                       class="cursor-pointer underline font-medium text-zinc-800 dark:text-zinc-100">
                        {{ $transfer->screenTo?->title ?? '—' }}
                    </a>
                </div>

                {{-- Title --}}
                <span class="text-sm text-zinc-600 dark:text-zinc-300">
                    {{ $transfer->title ?: '—' }}
                </span>

                {{-- Tooltip --}}
                <span class="text-sm text-zinc-500 dark:text-zinc-400">
                    {{ $transfer->tooltip ?: '—' }}
                </span>

                {{-- Arrow --}}
                <span class="text-right text-sm text-zinc-400 dark:text-zinc-500" x-text="open ? '▲' : '▼'"></span>
            </div>

            {{-- Expandable section --}}
            <div x-show="open" x-transition class="px-6 pb-4 pt-2 text-sm text-zinc-700 dark:text-zinc-300">
                <div class="mb-3">
                    <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400">Title</label>
                    <p>{{ $transfer->title ?: '—' }}</p>
                </div>

                <div class="mb-3">
                    <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400">Tooltip</label>
                    <p>{{ $transfer->tooltip ?: '—' }}</p>
                </div>

                <div class="mb-3">
                    <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400">Active (JSON)</label>
                    <pre class="bg-zinc-100 dark:bg-zinc-800 p-2 rounded text-xs overflow-auto">
{{ $transfer->active ?? '—' }}
                    </pre>
                </div>
            </div>
        </div>
    @endforeach
</div>
