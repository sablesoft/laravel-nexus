<script>
    document.addEventListener("DOMContentLoaded", function() {
        Livewire.on('uri', (data) => {
            window.history.pushState({}, '', data.uri);
            console.debug('[URI][Changed]', data);
        });
        console.debug('[URI][Init]');
    });
</script>
