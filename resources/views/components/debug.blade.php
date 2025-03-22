@props([
    'config' => [],
])
<!--suppress JSUnresolvedReference -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let config = @json($config);
        window.Debug = function(component, msg, context = null) {
            if (!config.is_enabled) return;
            Livewire.dispatch('debug', {component: component, message: msg, context: context});
        };
        Livewire.on('debug', (data) => {
            if (config.components?.[data.component]) {
                console.debug(`[${data.component}][${data.message}]`, data.context);
            }
        });
        if (config?.is_enabled) {
            console.debug('[debug][init]');
        }
    });
</script>
