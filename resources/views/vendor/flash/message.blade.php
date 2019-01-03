<script>
    @foreach (session('flash_notification', collect())->toArray() as $message)
    iziToast.show({
        message: '{{ $message['message'] }}',
        rtl: true,
        position: 'bottomLeft',

        @if($message['level'] == 'success')
        color: 'green',
        @endif

                @if($message['level'] == 'warning')
        color: 'yellow',
        @endif

                @if($message['level'] == 'danger')
        color: 'red',
        @endif

                @if($message['level'] == 'info')
        color: 'blue',
        @endif
    });
    @endforeach
</script>
{{ session()->forget('flash_notification') }}