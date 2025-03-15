@props([
    'channel' => 'users',
    'events' => [],
])

@script
<script>
    let initPresence = function (channel) {
        console.debug('[Presence][Init]', channel);
        let presenceChannel = Echo.join(channel);
            presenceChannel.here((users) => {
                console.debug('[Presence][Here]', channel, users);
                $wire.dispatchSelf('usersHere', {members: users});
            }).joining((user) => {
                console.debug('[Presence][Joining]', channel, user.id);
                $wire.dispatchSelf('userJoining', {id: user.id});
            }).leaving((user) => {
                console.debug('[Presence][Leaving]', channel, user.id);
                $wire.dispatchSelf('userLeaving', {id: user.id});
            }).error((error) => {
                console.error(error);
            });
        let events = @json($events);
        Object.entries(events).forEach(([event, handler]) => {
            console.log('[Presence][Listen]', channel +': '+ event +' => '+  handler);
            presenceChannel.listen(`.${event}`, (e) => {
                console.log('[Presence][Event]', channel +': '+ event, e);
                if (handler && typeof $wire !== 'undefined') {
                    $wire.dispatch(handler, e);
                }
            });
        });
    }
    let navigate = function(channel) {
        console.debug(`[Presence][Navigate] Leave ${channel}`);
        Echo.leave(channel);
    }
    document.addEventListener("livewire:navigate", function () {
        navigate('{{ $channel }}');
    });
    initPresence('{{ $channel }}');
</script>
@endscript
