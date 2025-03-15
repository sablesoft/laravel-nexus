@props([
    'channel' => 'public',
    'events' => []
])

@script
<script>
    let initPublic = function (channel) {
        console.debug('[Public][Init]', channel);
        let events = @json($events);
        let publicChannel = Echo.channel(channel);
        publicChannel.listen('.refresh', (e) => {
            console.log('[Public][Refresh]', e);
            $wire.$refresh();
        });
        Object.entries(events).forEach(([event, handler]) => {
            console.log('[Public][Listen]', channel +': '+ event +' => '+  handler);
            publicChannel.listen(`.${event}`, (e) => {
                console.log('[Public][Event]', channel +': '+ event, e);
                if (handler && typeof $wire !== 'undefined') {
                    $wire.dispatch(handler, e);
                }
            });
        });
    }
    let navigate = function(channel) {
        console.debug(`[Public][Navigate] Leave ${channel}`);
        Echo.leave(channel);
    }
    document.addEventListener("livewire:navigate", function () {
        navigate('{{ $channel }}');
    });
    initPublic('{{ $channel }}');
</script>
@endscript
