<!--suppress JSUnresolvedReference -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof Echo !== 'undefined') {
            Echo.private('users.{{ auth()->id() }}')
                .notification((notification) => {
                    console.debug('[Notification][Get]', notification);
                    if (notification.refresh) {
                        Livewire.dispatch('refresh.' + notification.refresh);
                    }
                    if (notification.flash) {
                        Livewire.dispatch('flash', {
                            message: notification.flash,
                            link: notification.link
                        });
                    }
                });
            console.debug('[Notification][Init]');
        } else {
            console.error('Echo is not initialized');
        }
    });
</script>
