@props([
    'path' => '',
    'alt' => '',
    'uuid' => uuid_create()
])

<div class="relative inline-block w-full h-full hover:scale-105 transition-transform">
    @if(!$path)
        <span class="text-gray-500">No Image</span>
    @else
        <img src="{{ Storage::url($path) }}" alt="{{ $alt }}" class="object-contain">
        <div x-on:click.stop="$flux.modal('image-viewer-{{ $uuid }}').show()"
             class="cursor-pointer absolute inset-0 flex items-center justify-center bg-black opacity-0 hover:opacity-70 transition-opacity">
            <flux:button class="cursor-pointer" icon="eye"/>
        </div>
        <flux:modal name="image-viewer-{{ $uuid }}" class="!max-w-full !max-h-full">
            <div class="flex justify-center items-center w-full h-full">
                <img src="{{ Storage::url($path) }}" class="max-w-full max-h-full object-contain">
            </div>
        </flux:modal>
    @endif
</div>
