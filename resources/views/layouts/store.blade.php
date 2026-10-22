<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="FurniCasa — modern, beautifully designed furniture for living rooms, bedrooms, dining rooms and beyond.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FurniCasa | Live Beautifully') — FurniCasa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen">
    @include('partials.toasts')
    <div class="bg-[#242424] text-white/90 text-[10px] sm:text-xs">
        <div class="site-container flex min-h-8 items-center justify-between gap-4 py-1">
            <span class="flex items-center gap-2"><x-icon name="truck"
                    class="h-4 w-4" />{{ $settings['announcement'] ?? 'FREE DELIVERY on all orders $499+' }}</span>
            <span class="hidden md:block">Premium Quality &nbsp; · &nbsp; Modern Designs &nbsp; · &nbsp; Great
                Prices</span>
            <span class="hidden sm:block">Need help? {{ $settings['support_phone'] ?? '+1 234 567 8900' }}</span>
        </div>
    </div>
    <header class="relative z-40 border-b border-stone-100 bg-white">
        <div class="site-container flex h-[76px] items-center justify-between gap-5">
            <a href="{{ route('home') }}" class="flex min-w-max items-center gap-3" aria-label="FurniCasa home">
                <span class="flex h-11 w-11 items-center justify-center rounded border border-[#d4c8a4] text-olive">
                    <x-icon name="sofa" class="h-8 w-8" />
                </span>
                <span><span class="block font-serif text-[27px] leading-7 tracking-tight">FurniCasa</span><span
                        class="block text-[8px] tracking-[.3em] text-olive">LIVE BEAUTIFULLY</span></span>
            </a>
            <nav class="hidden items-center gap-6 lg:flex text-[13px] font-semibold">
                <a href="{{ route('home') }}"
                    class="{{ request()->routeIs('home') ? 'text-olive' : 'hover:text-olive' }}">Home</a>
                <a href="{{ route('shop') }}"
                    class="{{ request()->routeIs('shop') ? 'text-olive' : 'hover:text-olive' }}">Shop</a>
                <a href="{{ route('shop') }}#catalog" class="hover:text-olive">Collections</a>
                @foreach ($categories->take(4) as $category)
                    <a href="{{ route('categories.show', $category) }}"
                        class="hover:text-olive">{{ $category->name }}</a>
                @endforeach
                <a href="{{ route('about') }}" class="hover:text-olive">About Us</a>
            </nav>
            <div class="flex items-center gap-3 sm:gap-5">
                <form action="{{ route('shop') }}"
                    class="hidden sm:flex items-center border-b border-transparent focus-within:border-olive"><input
                        name="q" value="{{ request('q') }}" placeholder="Search..." aria-label="Search products"
                        class="w-20 border-0 p-1 text-xs focus:ring-0 xl:w-28"><button aria-label="Search"
                        class="p-1 text-ink"><x-icon name="search" class="h-5 w-5" /></button></form>
                <a href="{{ auth()->check() ? route('account.index') : route('login') }}" aria-label="My account"
                    class="hover:text-olive"><x-icon name="user" class="h-[21px] w-[21px]" /></a>
                <a href="{{ route('cart.index') }}" aria-label="Shopping cart"
                    class="relative hover:text-olive"><x-icon name="cart-plus" class="h-[22px] w-[22px]" />
                    @if ($cartCount > 0)
                        <span
                            class="absolute -right-2 -top-2 rounded-full bg-gold px-1.5 text-[10px] font-bold text-white">{{ $cartCount }}</span>
                    @endif
                </a>
                <button type="button" data-toggle-menu aria-expanded="false" aria-label="Toggle navigation"
                    class="p-1 lg:hidden"><x-icon name="menu" class="h-6 w-6" /></button>
            </div>
        </div>
        <div data-mobile-menu class="hidden border-t border-stone-100 bg-white px-6 py-5 shadow-soft lg:hidden">
            <div class="flex flex-col gap-4 text-sm font-medium"><a href="{{ route('home') }}">Home</a><a
                    href="{{ route('shop') }}">Shop All</a>
                @foreach ($categories as $category)
                    <a href="{{ route('categories.show', $category) }}">{{ $category->name }}</a>
                @endforeach
                <a href="{{ route('about') }}">
                    About Us</a><a href="{{ route('contact') }}">Contact</a>
            </div>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
    <footer class="border-t border-stone-100 bg-[#faf9f6] pt-14">
        <div class="site-container grid gap-10 pb-14 sm:grid-cols-2 lg:grid-cols-5">
            <div class="lg:col-span-1"><a href="{{ route('home') }}" class="font-serif text-3xl">FurniCasa</a>
                <p class="mt-1 text-[9px] uppercase tracking-[.29em] text-olive">Live beautifully</p>
                <p class="mt-5 text-sm leading-7 text-muted">Quality furniture for every home. Designed to inspire.
                    Built to last.</p>
            </div>
            <div>
                <h3 class="mb-5 text-xs font-bold uppercase tracking-widest text-olive">Shop</h3>
                <ul class="space-y-3 text-sm text-stone-600">
                    <li><a href="{{ route('shop') }}">All Products</a></li>
                    @foreach ($categories->take(5) as $c)
                        <li><a href="{{ route('categories.show', $c) }}">{{ $c->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h3 class="mb-5 text-xs font-bold uppercase tracking-widest text-olive">Customer Service</h3>
                <ul class="space-y-3 text-sm text-stone-600">
                    <li><a href="{{ route('account.orders') }}">Track Your Order</a></li>
                    <li><a href="{{ route('contact') }}">Contact Support</a></li>
                    <li><a href="{{ route('contact') }}">Shipping Information</a></li>
                    <li><a href="{{ route('contact') }}">Returns & Refunds</a></li>
                </ul>
            </div>
            <div>
                <h3 class="mb-5 text-xs font-bold uppercase tracking-widest text-olive">About Us</h3>
                <ul class="space-y-3 text-sm text-stone-600">
                    <li><a href="{{ route('about') }}">Our Story</a></li>
                    <li><a href="{{ route('about') }}">Sustainability</a></li>
                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                </ul>
            </div>
            <div>
                <h3 class="mb-5 text-xs font-bold uppercase tracking-widest text-olive">Contact Us</h3>
                <ul class="space-y-3 text-sm leading-6 text-stone-600">
                    <li>{{ $settings['support_phone'] ?? '+1 234 567 8900' }}</li>
                    <li>{{ $settings['support_email'] ?? 'hello@furnicasa.com' }}</li>
                    <li>{{ $settings['address'] ?? '123 Furniture Street, New York, NY' }}</li>
                    <li>Mon – Sat: 9:00 AM – 7:00 PM</li>
                </ul>
            </div>
        </div>
        <div
            class="site-container flex flex-col gap-3 border-t border-stone-200 py-6 text-xs text-stone-500 sm:flex-row sm:justify-between">
            <span>© {{ date('Y') }} FurniCasa. All rights reserved.</span><span>Thoughtfully designed interiors ·
                Crafted for everyday living</span>
        </div>
    </footer>
</body>

</html>
