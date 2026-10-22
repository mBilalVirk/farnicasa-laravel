@php
    $toasts = [];

    foreach (['success', 'error', 'warning', 'info'] as $type) {
        $messages = session($type, []);
        $messages = is_string($messages) ? [$messages] : $messages;

        if (is_array($messages)) {
            foreach ($messages as $message) {
                if (is_string($message) && $message !== '') {
                    $toasts[] = [
                        'type' => $type,
                        'message' => $message,
                    ];
                }
            }
        }
    }

    foreach ($errors->all() as $message) {
        $toasts[] = [
            'type' => 'error',
            'message' => $message,
        ];
    }
@endphp

@if (count($toasts))
    <div class="toast-stack" data-toast-stack aria-live="polite" aria-atomic="false">

        @foreach ($toasts as $toast)
            <div class="toast toast--{{ $toast['type'] }}" data-toast
                data-duration="{{ $toast['type'] === 'error' ? 8000 : 6000 }}"
                role="{{ $toast['type'] === 'error' ? 'alert' : 'status' }}">
                <span class="toast__icon" aria-hidden="true">
                    @if ($toast['type'] === 'success')
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="m5 12 4 4L19 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    @elseif ($toast['type'] === 'error')
                        <svg viewBox="0 0 24 24" fill="none">
                            <path
                                d="M12 9v4m0 4h.01M10.3 3.86 1.82 18.5a2 2 0 0 0 1.73 2.5h16.9a2 2 0 0 0 1.73-2.5L13.7 3.86a2 2 0 0 0-3.4 0Z"
                                stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    @elseif ($toast['type'] === 'warning')
                        <svg viewBox="0 0 24 24" fill="none">
                            <path
                                d="M12 9v4m0 4h.01M10.3 3.86 1.82 18.5a2 2 0 0 0 1.73 2.5h16.9a2 2 0 0 0 1.73-2.5L13.7 3.86a2 2 0 0 0-3.4 0Z"
                                stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    @else
                        <svg viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8" />
                            <path d="M12 11v5m0-8h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    @endif
                </span>

                <div class="toast__content">
                    <span class="toast__title">
                        @switch($toast['type'])
                            @case('success')
                                Success
                            @break

                            @case('error')
                                Something went wrong
                            @break

                            @case('warning')
                                Attention required
                            @break

                            @default
                                Information
                        @endswitch
                    </span>

                    <p class="toast__message">{{ $toast['message'] }}</p>
                </div>

                <button class="toast__close" type="button" data-toast-dismiss aria-label="Dismiss notification">
                    <svg viewBox="0 0 20 20" fill="none" aria-hidden="true">
                        <path d="m5 5 10 10M15 5 5 15" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" />
                    </svg>
                </button>

                <span class="toast__progress" aria-hidden="true"></span>
            </div>
        @endforeach
    </div>
@endif
