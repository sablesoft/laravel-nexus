<flux:tooltip content="Aspect ratio filter">
    <flux:select id="filterAspect" wire:model.live="filterAspect" placeholder="Ratio" class="cursor-pointer">
        <flux:select.option value="all">{{ __('All') }}</flux:select.option>
        @foreach(\App\Services\OpenAI\Enums\ImageAspect::options() as $value => $title)
            <flux:select.option :value="$value">{{ __($title) }}</flux:select.option>
        @endforeach
    </flux:select>
</flux:tooltip>
<flux:tooltip content="Style filter">
    <flux:select id="filterStyle" wire:model.live="filterStyle" placeholder="Style" class="cursor-pointer">
        <flux:select.option value="all">{{ __('All') }}</flux:select.option>
        @foreach(\App\Services\OpenAI\Enums\ImageStyle::options() as $value => $title)
            <flux:select.option :value="$value">{{ __($title) }}</flux:select.option>
        @endforeach
    </flux:select>
</flux:tooltip>
<flux:tooltip content="Quality filter">
    <flux:select id="filterQuality" wire:model.live="filterQuality" placeholder="Quality" class="cursor-pointer">
        <flux:select.option value="all">{{ __('All') }}</flux:select.option>
        @foreach(\App\Services\OpenAI\Enums\ImageQuality::options() as $value => $title)
            <flux:select.option :value="$value">{{ __($title) }}</flux:select.option>
        @endforeach
    </flux:select>
</flux:tooltip>
<flux:tooltip content="Rendering artifacts filter">
    <flux:select id="filterHasGlitches" wire:model.live="filterHasGlitches" placeholder="Rendering Artifacts"
                 class="cursor-pointer">
        <flux:select.option value="all">{{ __('All') }}</flux:select.option>
        <flux:select.option value="yes">{{ __('Yes') }}</flux:select.option>
        <flux:select.option value="no">{{ __('No') }}</flux:select.option>
    </flux:select>
</flux:tooltip>
