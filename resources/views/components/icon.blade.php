@props(['name', 'class' => 'h-5 w-5', 'filled' => false])

@php
    $icons = [
        'alert' =>
            'M12 9v4m0 4h.01M10.3 3.86 1.82 18.5a2 2 0 0 0 1.73 2.5h16.9a2 2 0 0 0 1.73-2.5L13.7 3.86a2 2 0 0 0-3.4 0Z',
        'arrow-left' => 'M19 12H5m7 7-7-7 7-7',
        'arrow-right' => 'M5 12h14m-7-7 7 7-7 7',
        'box' =>
            'M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8Zm-18 .3 9 5.2 9-5.2M12 22V13.5',
        'cart-plus' => 'M3 4h2l2.5 12h11.3L21 7H6m6 2v5m-2.5-2.5h5M9 20h.01M18 20h.01',
        'category' => 'M3 3h8v8H3zM13 3h8v5h-8zM13 10h8v11h-8zM3 13h8v8H3z',
        'check' => 'm5 12 4 4L19 6',
        'clock' => 'M12 8v4l3 2m6-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
        'close' => 'm5 5 14 14M19 5 5 19',
        'dashboard' => 'M3 3h8v8H3zM13 3h8v5h-8zM13 10h8v11h-8zM3 13h8v8H3z',
        'external-link' => 'M14 3h7v7m0-7-11 11m8-1v7H3V5h7',
        'info' => 'M12 11v5m0-8h.01M22 12a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z',
        'headset' =>
            'M3 14v-3a9 9 0 0 1 18 0v3m-18 0v4a2 2 0 0 0 2 2h2v-8H5a2 2 0 0 0-2 2Zm18 0v4a2 2 0 0 1-2 2h-2v-8h2a2 2 0 0 1 2 2Z',
        'logout' => 'M10 17l5-5-5-5m5 5H3m9-9h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6',
        'mail' => 'M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Zm18 3-10 7L2 7',
        'menu' => 'M3 7h18M3 12h18M3 17h18',
        'orders' => 'M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01',
        'package' => 'm12 3 9 5-9 5-9-5 9-5Zm-9 5v9l9 5 9-5V8m-9 5v9',
        'recycle' => 'm7 7 2-3 3 2m5 1 2 3-3 2m-10 5-3-1 1-4m5-2 3 5m2-6-2 3m-6 5 3-1',
        'search' => 'M11 19a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm6-2 4 4',
        'shield' => 'M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11Z',
        'settings' =>
            'M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm0-5v2m0 14v2m9-9h-2M5 12H3m15.36-6.36-1.42 1.42M7.06 16.94l-1.42 1.42m12.72 0-1.42-1.42M7.06 7.06 5.64 5.64',
        'shield-check' => 'M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11Zm-4-11 3 3 5-5',
        'sofa' =>
            'M4 11V6a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v5M4 11a2 2 0 0 0-2 2v5h20v-5a2 2 0 0 0-2-2 2 2 0 0 0-2 2v1H6v-1a2 2 0 0 0-2-2ZM4 18v3m16-3v3M8 9h8',
        'star' => 'm12 3 2.78 5.63 6.22.9-4.5 4.39 1.06 6.2L12 17.19l-5.56 2.93 1.06-6.2L3 9.53l6.22-.9L12 3Z',
        'tag' => 'M20.59 13.41 11 3.83V3H4v7h.83l9.58 9.59a2 2 0 0 0 2.83 0l3.35-3.35a2 2 0 0 0 0-2.83ZM7.5 7.5h.01',
        'truck' => 'M3 6h11v12H3zM14 10h4l3 3v5h-7m-7 0h.01M18 18h.01M14 13h6',
        'user' => 'M20 21a8 8 0 0 0-16 0m8-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z',
        'users' => 'M16 21a6 6 0 0 0-12 0m6-10a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm5-5a3 3 0 0 1 0 6m5 9a6 6 0 0 0-5-5.91',
    ];
    $path = $icons[$name] ?? $icons['info'];
@endphp

<svg {{ $attributes->class($class) }} viewBox="0 0 24 24" fill="{{ $filled ? 'currentColor' : 'none' }}"
    stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    <path d="{{ $path }}" />
</svg>
