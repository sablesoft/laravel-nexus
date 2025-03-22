@props([
    'channel' => 'public',
    'events' => []
])

@script
<!--suppress JSUnresolvedReference -->
<script>
    let initPublic = function (channel) {
        Debug('echo-public','init', channel);
        let events = @json($events);
        let publicChannel = Echo.channel(channel);
        publicChannel.listen('.refresh', () => {
            Debug('echo-public','refresh');
            $wire.$refresh();
        });
        Object.entries(events).forEach(([event, handler]) => {
            Debug('echo-public','listen', channel +': '+ event +' => '+  handler);
            publicChannel.listen(`.${event}`, (e) => {
                Debug('echo-public','event', {name: channel +': '+ event, event: e});
                if (handler && typeof $wire !== 'undefined') {
                    $wire.dispatch(handler, e);
                }
            });
        });
    }
    let navigate = function(channel) {
        Debug('echo-public','navigate',`Leave ${channel}`);
        Echo.leave(channel);
    }
    document.addEventListener("livewire:navigate", function () {
        navigate('{{ $channel }}');
    });
    initPublic('{{ $channel }}');
</script>
@endscript
