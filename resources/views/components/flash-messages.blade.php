@php
    $messages = [];

    foreach (['success', 'error', 'warning', 'info'] as $type) {
        $value = session($type);

        if (filled($value)) {
            $messages[] = [
                'type' => $type === 'error' ? 'error' : $type,
                'message' => $value,
            ];
        }
    }

    if (session('status')) {
        $messages[] = [
            'type' => 'success',
            'message' => session('status'),
        ];
    }

    if ($errors->any()) {
        foreach ($errors->all() as $errorMessage) {
            $messages[] = [
                'type' => 'error',
                'message' => $errorMessage,
            ];
        }
    }
@endphp

@if ($messages !== [])
    <div class="fh-flash-stack" aria-live="polite" aria-atomic="true">
        @foreach ($messages as $message)
            <div class="fh-inline-alert fh-inline-alert-{{ $message['type'] }}" role="alert" data-flash-toast="true" data-flash-type="{{ $message['type'] }}" data-flash-message="{{ e($message['message']) }}">
                <span class="fh-inline-alert-icon">
                    @if ($message['type'] === 'success')
                        <i class="fas fa-check-circle"></i>
                    @elseif ($message['type'] === 'warning')
                        <i class="fas fa-triangle-exclamation"></i>
                    @elseif ($message['type'] === 'info')
                        <i class="fas fa-circle-info"></i>
                    @else
                        <i class="fas fa-circle-xmark"></i>
                    @endif
                </span>
                <div class="fh-inline-alert-copy">{{ $message['message'] }}</div>
            </div>
        @endforeach
    </div>
@endif
