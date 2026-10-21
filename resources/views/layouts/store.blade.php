<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
 <meta name="description" content="FurniCasa — modern, beautifully designed furniture for living rooms, bedrooms, dining rooms and beyond.">
 <meta name="csrf-token" content="{{ csrf_token() }}">
 <title>@yield('title','FurniCasa | Live Beautifully') — FurniCasa</title>
 @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen">
 <div class="bg-[#242424] text-white/90 text-[10px] sm:text-xs">
  <div class="site-container flex min-h-8 items-center justify-between gap-4 py-1">
   <span>♧ &nbsp; {{ $settings['announcement']??'FREE DELIVERY on all orders $499+' }}</span>
   <span class="hidden md:block">Premium Quality &nbsp; · &nbsp; Modern Designs &nbsp; · &nbsp; Great Prices</span>
   <span class="hidden sm:block">Need help? {{ $settings['support_phone']??'+1 234 567 8900' }}</span>
  </div>
 </div>
 <header class="relative z-40 border-b border-stone-100 bg-white">
  <div class="site-container flex h-[76px] items-center justify-between gap-5">
   <a href="{{ route('home') }}" class="flex min-w-max items-center gap-3" aria-label="FurniCasa home">
    <span class="flex h-11 w-11 items-center justify-center rounded border border-[#d4c8a4] text-olive">
     <svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 11V6a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v5"/><path d="M4 11a2 2 0 0 0-2 2v5h20v-5a2 2 0 0 0-2-2 2 2 0 0 0-2 2v1H6v-1a2 2 0 0 0-2-2Z"/><path d="M4 18v3m16-3v3M8 9h8"/></svg>
    </span>
    <span><span class="block font-serif text-[27px] leading-7 tracking-tight">FurniCasa</span><span class="block text-[8px] tracking-[.3em] text-olive">LIVE BEAUTIFULLY</span></span>
   </a>
   <nav class="hidden items-center gap-6 lg:flex text-[13px] font-semibold">
    <a href="{{ route('home') }}" class="{{ request()->routeIs('home')?'text-olive':'hover:text-olive' }}">Home</a>
    <a href="{{ route('shop') }}" class="{{ request()->routeIs('shop')?'text-olive':'hover:text-olive' }}">Shop</a>
    <a href="{{ route('shop') }}#catalog" class="hover:text-olive">Collections</a>
    @foreach($categories->take(4) as $category)
     <a href="{{ route('categories.show',$category) }}" class="hover:text-olive">{{ $category->name }}</a>
    @endforeach
    <a href="{{ route('about') }}" class="hover:text-olive">About Us</a>
   </nav>
   <div class="flex items-center gap-3 sm:gap-5">
    <form action="{{ route('shop') }}" class="hidden sm:flex items-center border-b border-transparent focus-within:border-olive"><input name="q" value="{{ request('q') }}" placeholder="Search..." aria-label="Search products" class="w-20 border-0 p-1 text-xs focus:ring-0 xl:w-28"><button aria-label="Search" class="p-1 text-ink"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m16 16 5 5"/></svg></button></form>
    <a href="{{ auth()->check()?route('account.index'):route('login') }}" aria-label="My account" class="hover:text-olive"><svg width="21" height="21" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"/><path d="M3.5 21a8.5 8.5 0 0 1 17 0"/></svg></a>
    <a href="{{ route('cart.index') }}" aria-label="Shopping cart" class="relative hover:text-olive"><svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M3 4h2l2.4 12h11.5l2-9H6"/><circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/></svg>@if($cartCount>0)<span class="absolute -right-2 -top-2 rounded-full bg-gold px-1.5 text-[10px] font-bold text-white">{{ $cartCount }}</span>@endif</a>
    <button type="button" data-toggle-menu aria-expanded="false" aria-label="Toggle navigation" class="p-1 lg:hidden"><svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 7h18M3 12h18M3 17h18"/></svg></button>
   </div>
  </div>
  <div data-mobile-menu class="hidden border-t border-stone-100 bg-white px-6 py-5 shadow-soft lg:hidden"><div class="flex flex-col gap-4 text-sm font-medium"><a href="{{ route('home') }}">Home</a><a href="{{ route('shop') }}">Shop All</a>@foreach($categories as $category)<a href="{{ route('categories.show',$category) }}">{{ $category->name }}</a>@endforeach<a href="{{ route('about') }}">About Us</a><a href="{{ route('contact') }}">Contact</a></div></div>
 </header>
 <main>
  @if(session('success'))<div class="site-container mt-5"><div role="status" class="rounded-md border border-emerald-200 bg-emerald-50 px-5 py-3 text-sm text-emerald-800">{{ session('success') }}</div></div>@endif
  @if($errors->any())<div class="site-container mt-5"><div role="alert" class="rounded-md border border-red-200 bg-red-50 px-5 py-3 text-sm text-red-800"><strong>Please check the following:</strong><ul class="mt-1 list-inside list-disc">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div></div>@endif
  @yield('content')
 </main>
 <footer class="border-t border-stone-100 bg-[#faf9f6] pt-14">
  <div class="site-container grid gap-10 pb-14 sm:grid-cols-2 lg:grid-cols-5">
   <div class="lg:col-span-1"><a href="{{ route('home') }}" class="font-serif text-3xl">FurniCasa</a><p class="mt-1 text-[9px] uppercase tracking-[.29em] text-olive">Live beautifully</p><p class="mt-5 text-sm leading-7 text-muted">Quality furniture for every home. Designed to inspire. Built to last.</p></div>
   <div><h3 class="mb-5 text-xs font-bold uppercase tracking-widest text-olive">Shop</h3><ul class="space-y-3 text-sm text-stone-600"><li><a href="{{ route('shop') }}">All Products</a></li>@foreach($categories->take(5) as $c)<li><a href="{{ route('categories.show',$c) }}">{{ $c->name }}</a></li>@endforeach</ul></div>
   <div><h3 class="mb-5 text-xs font-bold uppercase tracking-widest text-olive">Customer Service</h3><ul class="space-y-3 text-sm text-stone-600"><li><a href="{{ route('account.orders') }}">Track Your Order</a></li><li><a href="{{ route('contact') }}">Contact Support</a></li><li><a href="{{ route('contact') }}">Shipping Information</a></li><li><a href="{{ route('contact') }}">Returns & Refunds</a></li></ul></div>
   <div><h3 class="mb-5 text-xs font-bold uppercase tracking-widest text-olive">About Us</h3><ul class="space-y-3 text-sm text-stone-600"><li><a href="{{ route('about') }}">Our Story</a></li><li><a href="{{ route('about') }}">Sustainability</a></li><li><a href="{{ route('contact') }}">Contact Us</a></li></ul></div>
   <div><h3 class="mb-5 text-xs font-bold uppercase tracking-widest text-olive">Contact Us</h3><ul class="space-y-3 text-sm leading-6 text-stone-600"><li>{{ $settings['support_phone']??'+1 234 567 8900' }}</li><li>{{ $settings['support_email']??'hello@furnicasa.com' }}</li><li>{{ $settings['address']??'123 Furniture Street, New York, NY' }}</li><li>Mon – Sat: 9:00 AM – 7:00 PM</li></ul></div>
  </div>
  <div class="site-container flex flex-col gap-3 border-t border-stone-200 py-6 text-xs text-stone-500 sm:flex-row sm:justify-between"><span>© {{ date('Y') }} FurniCasa. All rights reserved.</span><span>Thoughtfully designed interiors · Crafted for everyday living</span></div>
 </footer>
</body></html>
