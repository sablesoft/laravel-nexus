<flux:tooltip content="{{ __('Aspect ratio filter') }}">
    <flux:select id="filterAspect" wire:model.live="filterAspect" placeholder="{{ __('Ratio') }}" class="cursor-pointer">
        <flux:select.option value="all">{{ __('All') }}</flux:select.option>
        @foreach(\App\Services\OpenAI\Enums\ImageAspect::options() as $value => $title)
            <flux:select.option :value="$value">{{ __($title) }}</flux:select.option>
        @endforeach
    </flux:select>
</flux:tooltip>
<flux:tooltip content="{{ __('Style filter') }}">
    <flux:select id="filterStyle" wire:model.live="filterStyle" placeholder="{{ __('Style') }}" class="cursor-pointer">
        <flux:select.option value="all">{{ __('All') }}</flux:select.option>
        @foreach(\App\Services\OpenAI\Enums\ImageStyle::options() as $value => $title)
            <flux:select.option :value="$value">{{ __($title) }}</flux:select.option>
        @endforeach
    </flux:select>
</flux:tooltip>
<flux:tooltip content="{{ __('Quality filter') }}">
    <flux:select id="filterQuality" wire:model.live="filterQuality" placeholder="{{ __('Quality') }}" class="cursor-pointer">
        <flux:select.option value="all">{{ __('All') }}</flux:select.option>
        @foreach(\App\Services\OpenAI\Enums\ImageQuality::options() as $value => $title)
            <flux:select.option :value="$value">{{ __($title) }}</flux:select.option>
        @endforeach
    </flux:select>
</flux:tooltip>
<flux:tooltip content="{{ __('Rendering artifacts filter') }}">
    <flux:select id="filterHasGlitches" wire:model.live="filterHasGlitches" placeholder="{{ __('Rendering Artifacts') }}"
                 class="cursor-pointer">
        <flux:select.option value="all">{{ __('All') }}</flux:select.option>
        <flux:select.option value="yes">{{ __('Yes') }}</flux:select.option>
        <flux:select.option value="no">{{ __('No') }}</flux:select.option>
    </flux:select>
</flux:tooltip>
