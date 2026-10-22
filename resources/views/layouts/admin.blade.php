<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | FurniCasa Admin</title>@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#f6f5f2]">@include('partials.toasts')<div class="min-h-screen lg:flex">
        <aside
            class="w-full shrink-0 border-r border-stone-200 bg-white lg:fixed lg:inset-y-0 lg:w-[252px] lg:overflow-y-auto">
            <div class="flex h-[72px] items-center justify-between border-b border-stone-100 px-6"><a
                    href="{{ route('admin.dashboard') }}" class="font-serif text-2xl">FurniCasa <span
                        class="text-xs font-sans text-olive">ADMIN</span></a><button aria-label="Toggle admin menu"
                    data-toggle-menu aria-expanded="false" class="lg:hidden"><x-icon name="menu"
                        class="h-6 w-6" /></button></div>
            <nav data-mobile-menu class="hidden space-y-1 px-3 py-5 lg:block">
                @foreach ([['admin.dashboard', 'Overview', 'dashboard'], ['admin.orders.index', 'Orders', 'orders'], ['admin.products.index', 'Products', 'package'], ['admin.categories.index', 'Categories', 'category'], ['admin.inventory.index', 'Inventory', 'box'], ['admin.coupons.index', 'Coupons', 'tag'], ['admin.customers.index', 'Customers', 'users'], ['admin.reviews.index', 'Reviews', 'star'], ['admin.contacts.index', 'Messages', 'mail'], ['admin.newsletters.index', 'Subscribers', 'mail'], ['admin.settings.index', 'Settings', 'settings']] as $link)
                    <a href="{{ route($link[0]) }}"
                        class="admin-nav-link {{ request()->routeIs($link[0]) || (str_contains($link[0], 'products.index') && request()->routeIs('admin.products.*')) || (str_contains($link[0], 'categories.index') && request()->routeIs('admin.categories.*')) || (str_contains($link[0], 'coupons.index') && request()->routeIs('admin.coupons.*')) || (str_contains($link[0], 'orders.index') && request()->routeIs('admin.orders.*')) ? 'active' : '' }}"><span
                            class="w-5 text-center"><x-icon :name="$link[2]"
                                class="h-5 w-5" /></span>{{ $link[1] }}</a>
                @endforeach
                <div class="my-4 border-t border-stone-100"></div><a class="admin-nav-link" href="{{ route('home') }}"
                    target="_blank"><x-icon name="external-link" class="h-4 w-4" />View Storefront</a>
                <form method="POST" action="{{ route('logout') }}">@csrf<button
                        class="admin-nav-link w-full text-left"><x-icon name="logout" class="h-4 w-4" />Log
                        Out</button></form>
            </nav>
        </aside>
        <div class="min-w-0 flex-1 lg:ml-[252px]">
            <header
                class="flex min-h-[72px] items-center justify-between border-b border-stone-200 bg-white px-5 sm:px-9">
                <span class="text-sm text-stone-500">Store Administration</span>
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-cream font-bold text-olive">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div><span
                        class="hidden text-sm font-semibold sm:block">{{ auth()->user()->name }}</span>
                </div>
            </header>
            <main class="mx-auto max-w-[1500px] p-5 sm:p-9">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
