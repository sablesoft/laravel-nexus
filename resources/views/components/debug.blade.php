@props([
    'config' => [],
])
<!--suppress JSUnresolvedReference -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let config = @json($config);
        window.Debug = function(component, message, context = null) {
            if (!config.is_enabled) return;
            Livewire.dispatch('debug', {component, message, context});
        };
        Livewire.on('debug', (data) => {
            if (!config.is_enabled) return;
            if (config.components?.[data.component]) {
                console.debug(`[${data.component}][${data.message}]`, data.context);
            }
        });
        if (config?.is_enabled) {
            console.debug('[debug][init]');
        }
    });
</script>
