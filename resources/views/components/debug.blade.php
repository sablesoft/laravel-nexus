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
        Livewire.on('debug', ({component, message, context = null}) => {
            if (!config.is_enabled) return;
            if (config.components?.[component]) {
                if (context) {
                    console.debug(`[${component}][${message}]`, context);
                } else {
                    console.debug(`[${component}][${message}]`);
                }
            }
        });
        if (config?.is_enabled) {
            console.debug('[debug][init]');
        }
    });
</script>
