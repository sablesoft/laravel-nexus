@props([
    'channel' => 'users',
    'events' => [],
])
@script
<!--suppress JSUnresolvedReference -->
<script>
    let initPresence = function (channel) {
        Debug('echo-presence','init',channel);
        let presenceChannel = Echo.join(channel);
            presenceChannel.here((users) => {
                Debug('echo-presence','here',{channel: channel, users: users});
                $wire.dispatchSelf('usersHere', {members: users});
            }).joining((user) => {
                Debug('echo-presence','joining',{channel: channel, userId: user.id});
                $wire.dispatchSelf('userJoining', {id: user.id});
            }).leaving((user) => {
                Debug('echo-presence','leaving',{channel: channel, userId: user.id});
                $wire.dispatchSelf('userLeaving', {id: user.id});
            }).error((error) => {
                console.error(error);
            });
        let events = @json($events);
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
    let navigate = function(channel) {
        Debug('echo-presence','navigate',`Leave ${channel}`);
        Echo.leave(channel);
    }
    document.addEventListener("livewire:navigate", function () {
        navigate('{{ $channel }}');
    });
    initPresence('{{ $channel }}');
</script>
@endscript
