<!--suppress JSUnresolvedReference -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof Echo !== 'undefined') {
            Echo.private('users.{{ auth()->id() }}')
                .notification((notification) => {
                    console.debug('[Notification] Get', notification);
                    if (notification.refresh) {
                        Livewire.dispatch('refresh.' + notification.refresh);
                    }
                    if (notification.flash) {
                        Livewire.dispatch('flash', {
                            message: notification.flash
                        });
                    }
                });
            console.debug('[Notification] Listening');
        } else {
            console.error('Echo is not initialized');
        }
    });
</script>
