<div x-data="{ show: false, message: '', link: '' }"
     x-show="show"
     x-transition
     x-on:click="show = false;"
     x-on:flash.window="console.debug('[Flash] Event', $event); message = $event.detail.message; link = $event.detail.link; show = true; setTimeout(() => show = false, 12000);"
     x-init="console.debug('[Flash] Init');"
     class="cursor-pointer fixed bottom-5 right-5 bg-zinc-100 dark:bg-zinc-900 border-zinc-200 dark:border-zinc-700 shadow-lg rounded-md p-2">
    <span x-show="!link" x-text="message"></span>
    <a x-show="!!link" :href="link" wire:navigate><span x-text="message"></span></a>
    <flux:button icon="x-mark" size="xs" disabled variant="subtle" />
</div>
