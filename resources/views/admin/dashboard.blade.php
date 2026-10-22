@extends('layouts.admin')
@section('title', 'Overview')
@section('content')
    <div class="mb-7 flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="section-eyebrow">Your Store at a Glance</p>
            <h1 class="mt-1 font-serif text-4xl">Dashboard</h1>
            <p class="mt-2 text-sm text-stone-500">Today is {{ now()->format('l, F j, Y') }}</p>
        </div><a href="{{ route('admin.products.create') }}" class="btn-dark">+ Add Product</a>
    </div>
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ([['Revenue (Paid)', '$' . number_format($stats['revenue'], 2), 'external-link'], ['Total Orders', number_format($stats['orders']), 'orders'], ['Customers', number_format($stats['customers']), 'users'], ['Low Stock Products', $stats['lowStock'], 'alert']] as $card)
            <div class="panel">
                <div class="flex items-center justify-between"><span
                        class="text-xs font-semibold uppercase tracking-wide text-stone-500">{{ $card[0] }}</span><span
                        class="flex h-9 w-9 items-center justify-center rounded-lg bg-paper text-olive"><x-icon
                            :name="$card[2]" class="h-5 w-5" /></span>
                </div>
                <div class="mt-4 text-3xl font-semibold tracking-tight">{{ $card[1] }}</div>
            </div>
        @endforeach
    </div>
    <div class="mt-7 grid gap-6 xl:grid-cols-[minmax(0,1fr)_340px]">
        <div class="panel overflow-hidden !p-0">
            <div class="flex justify-between px-5 py-5">
                <h2 class="font-serif text-2xl">Latest Orders</h2><a class="text-sm text-olive underline"
                    href="{{ route('admin.orders.index') }}">All Orders</a>
            </div>
            <div class="overflow-x-auto">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="font-semibold">{{ $order->order_number }}</td>
                                <td>{{ $order->name }}</td>
                                <td>${{ number_format($order->total, 2) }}</td>
                                <td><span class="status-pill">{{ $order->status }}</span></td>
                                <td><a href="{{ route('admin.orders.show', $order) }}" class="text-olive underline">View</a>
                                </td>
                        </tr>@empty<tr>
                                <td colspan="5">No orders yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel">
            <div class="flex justify-between gap-3">
                <h2 class="font-serif text-2xl">Low Stock Alerts</h2><a href="{{ route('admin.inventory.index') }}"
                    class="text-xs text-olive underline">Inventory</a>
            </div>
            <div class="mt-4 divide-y">
                @forelse($lowStock as $product)
                    <div class="flex items-center gap-3 py-3"><img src="{{ $product->image_url }}"
                            class="h-12 w-12 object-cover" alt=""><span
                            class="flex-1 text-sm font-medium">{{ $product->name }}</span><span
                            class="rounded bg-red-50 px-2 py-1 text-xs font-bold text-red-700">{{ $product->stock }}
                        left</span></div>@empty<p class="py-4 text-sm text-stone-500">Stock levels look healthy.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
