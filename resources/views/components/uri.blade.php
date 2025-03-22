<!--suppress JSUnresolvedReference -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Livewire.on('uri', (data) => {
            window.history.pushState({}, '', data.uri);
            Debug('uri', 'changed', data);
        });
        Debug('uri', 'init');
    });
</script>
