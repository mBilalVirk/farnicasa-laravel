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
                        <x-icon name="check" class="h-5 w-5" />
                    @elseif ($toast['type'] === 'error')
                        <x-icon name="alert" class="h-5 w-5" />
                    @elseif ($toast['type'] === 'warning')
                        <x-icon name="alert" class="h-5 w-5" />
                    @else
                        <x-icon name="info" class="h-5 w-5" />
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
                    <x-icon name="close" class="h-4 w-4" />
                </button>

                <span class="toast__progress" aria-hidden="true"></span>
            </div>
        @endforeach
    </div>
@endif
