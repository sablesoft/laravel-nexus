@props([
    'channel' => 'users',
])

@script
<script>
    let initPresence = function (channel) {
        console.debug('Join presence', channel);
        Echo.join(channel)
            .here((users) => {
                console.debug('[Presence][Here]', users);
                $wire.dispatchSelf('usersHere', {members: users});
            }).joining((user) => {
            console.debug('[Presence][Joining]', user.id);
            $wire.dispatchSelf('userJoining', {id: user.id});
        }).leaving((user) => {
            console.debug('[Presence][Leaving]', user.id);
            $wire.dispatchSelf('userLeaving', {id: user.id});
        }).error((error) => {
            console.error(error);
        });
    }
    let navigate = function(channel) {
        console.debug(`[Presence][Navigate] Leaving channel ${channel}`);
        Echo.leave(channel);
    }
    document.addEventListener("livewire:navigate", function () {
        navigate('{{ $channel }}');
    });
    initPresence('{{ $channel }}');
</script>
@endscript
