@props([
    'channels' => ['users' => []],
])
@script
<!--suppress JSUnresolvedReference -->
<script>
    let initPresence = function (channel, events) {
        Debug('echo-presence','init',channel);
        let presenceChannel = Echo.join(channel);
            presenceChannel.here((users) => {
                Debug('echo-presence','here',{channel, users});
                $wire.dispatchSelf('usersHere', {channel, users});
            }).joining((user) => {
                Debug('echo-presence','joining',{channel, userId: user.id});
                $wire.dispatchSelf('userJoining', {channel, id: user.id});
            }).leaving((user) => {
                Debug('echo-presence','leaving',{channel, userId: user.id});
                $wire.dispatchSelf('userLeaving', {channel, id: user.id});
            }).error((error) => {
                console.error(error);
            });
        Object.entries(events).forEach(([event, handler]) => {
            Debug('echo-presence','listen',channel +': '+ event +' => '+  handler);
            presenceChannel.listen(`.${event}`, (e) => {
                Debug('echo-presence','event',{name: channel +': '+ event, event: e});
                if (handler && typeof $wire !== 'undefined') {
                    $wire.dispatch(handler, e);
                }
            });
        });
    }
    let navigate = function(channels) {
        Debug('echo-presence','navigate', 'Leave', channels);
        Object.entries(channels).forEach(([channel, events]) => {
            Echo.leave(channel);
        });
    }
    document.addEventListener('swap-presence', function (e) {
        Echo.leave(e.detail.fromChannel);
        initPresence(e.detail.toChannel, e.detail.events);
    });

    let channels = @json($channels);
    document.addEventListener('livewire:navigate', function () {
        navigate(channels);
    });
    Object.entries(channels).forEach(([channel, events]) => {
        initPresence(channel, events);
    });
</script>
@endscript
