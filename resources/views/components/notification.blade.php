<!--suppress JSUnresolvedReference -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof Echo !== 'undefined') {
            Echo.private('users.{{ auth()->id() }}')
                .notification((notification) => {
                    Debug('notification', 'get', notification);
                    if (notification.refresh) {
                        Livewire.dispatch('refresh.' + notification.refresh);
                    }
                    if (notification.flash) {
                        Livewire.dispatch('flash', {
                            message: notification.flash,
                            link: notification.link
                        });
                    }
                    if (notification.debug) {
                        const {component, message, context = null} = notification.debug;
                        Debug(component, message, context);
                    }
                }).listen('swap', (e) => {
                    const { swapName, fromChannel, toChannel, events } = e.detail;
                    Debug('notification', 'Swap', { swapName, fromChannel, toChannel, events });
                    const swapEvent = new CustomEvent(swapName, {
                        detail: {fromChannel, toChannel, events : events ?? []}
                    });
                    window.dispatchEvent(swapEvent);
                });
            Debug('notification', 'init');
        } else {
            console.error('[notification] Echo is not initialized');
        }
    });
</script>
