@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="py-2 flex items-center justify-between">
            <div class="flex justify-between flex-1 sm:hidden">
                <flux:button wire:click="previousPage('{{ $paginator->getPageName() }}')"
                             :disabled="$paginator->onFirstPage()"
                             :class="!$paginator->onFirstPage() ? 'cursor-pointer' : ''"
                             x-on:click="{{ $scrollIntoViewJsSnippet }}"
                             wire:loading.attr="disabled">
                    {!! __('pagination.previous') !!}
                </flux:button>
                <flux:button wire:click="nextPage('{{ $paginator->getPageName() }}')"
                             :disabled="!$paginator->hasMorePages()"
                             :class="$paginator->hasMorePages() ? 'cursor-pointer' : ''"
                             x-on:click="{{ $scrollIntoViewJsSnippet }}"
                             wire:loading.attr="disabled">
                    {!! __('pagination.next') !!}
                </flux:button>
            </div>

            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700 leading-5 dark:text-gray-400">
                        <span>{!! __('Showing') !!}</span>
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        <span>{!! __('to') !!}</span>
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                        <span>{!! __('of') !!}</span>
                        <span class="font-medium">{{ $paginator->total() }}</span>
                        <span>{!! __('results') !!}</span>
                    </p>
                </div>

                <div>
                    <span class="relative z-0 inline-flex rtl:flex-row-reverse rounded-md shadow-sm">
                        <flux:button.group>
                        {{-- Previous Page Link --}}
                        <flux:tooltip content="{{ __('Previous') }}">
                            <flux:button icon="chevron-left"
                                         wire:click="previousPage('{{ $paginator->getPageName() }}')"
                                         x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                         dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after"
                                         :class="!$paginator->onFirstPage() ? 'cursor-pointer' : ''"
                                         :disabled="$paginator->onFirstPage()"></flux:button>
                        </flux:tooltip>

                        {{-- Pagination Elements --}}
                        @foreach ($elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <flux:button disabled>{{ $element }}</flux:button>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    <span wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}">
                                        <flux:tooltip content="{{ __('Go to page :page', ['page' => $page]) }}">
                                            <flux:button wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                                         x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                                         :class="$page != $paginator->currentPage() ? 'cursor-pointer' : ''"
                                                         :disabled="$page == $paginator->currentPage()">
                                                {{ $page }}
                                            </flux:button>
                                        </flux:tooltip>
                                    </span>
                                @endforeach
                            @endif
                        @endforeach
                        {{-- Next Page Link --}}
                        <flux:tooltip content="{{ __('Next') }}">
                            <flux:button icon="chevron-right"
                                         wire:click="nextPage('{{ $paginator->getPageName() }}')"
                                         x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                         dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after"
                                         :class="$paginator->hasMorePages() ? 'cursor-pointer' : ''"
                                         :disabled="!$paginator->hasMorePages()"></flux:button>
                        </flux:tooltip>
                    </flux:button.group>
                    </span>
                </div>
            </div>
        </nav>
    @endif
</div>
