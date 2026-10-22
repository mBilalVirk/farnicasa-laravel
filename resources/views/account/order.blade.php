@extends('layouts.store')
@section('title', 'Order ' . $order->order_number)
@section('content')
    <div class="site-container py-12">
        <div class="mb-8 flex flex-wrap items-start justify-between gap-4">
            <div>
                <p class="section-eyebrow">Thank you for shopping with us</p>
                <h1 class="mt-2 font-serif text-4xl">Order {{ $order->order_number }}</h1>
                <p class="mt-2 text-sm text-muted">Placed {{ $order->created_at->format('F j, Y') }}</p>
            </div><a href="{{ route('account.orders') }}" class="btn-outline">My Orders <x-icon name="arrow-right"
                    class="h-4 w-4" /></a>
        </div>
        <div class="grid gap-8 lg:grid-cols-[1fr_340px]">
            <div class="panel">
                <h2 class="font-serif text-2xl">Order Items</h2>
                <div class="mt-5 divide-y divide-stone-100">
                    @foreach ($order->items as $item)
                        <div class="flex justify-between gap-3 py-4 text-sm">
                            <div>
                                <p class="font-semibold">{{ $item->product_name }}</p>
                                <p class="mt-1 text-xs text-stone-500">{{ $item->sku }} · Qty {{ $item->quantity }}</p>
                            </div><span>${{ number_format($item->line_total, 2) }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 space-y-2 border-t pt-5 text-sm">
                    <div class="flex justify-between">
                        <span>Subtotal</span><span>${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Discount</span><span>−${{ number_format($order->discount, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Shipping</span><span>${{ number_format($order->shipping, 2) }}</span>
                    </div>
                    <div class="flex justify-between"><span>Tax</span><span>${{ number_format($order->tax, 2) }}</span>
                    </div>
                    <div class="flex justify-between pt-3 text-lg font-bold">
                        <span>Total</span><span>${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>
            <aside class="space-y-5">
                <div class="panel">
                    <h2 class="font-serif text-xl">Order Status</h2>
                    <p class="mt-4"><span class="status-pill">{{ $order->status }}</span></p>
                    <p class="mt-3 text-sm">Payment: <b>{{ ucfirst($order->payment_status) }}</b></p>
                    <p class="mt-1 text-sm">Method:
                        {{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Manual Bank Transfer' }}</p>
                    @if ($order->payment_method === 'bank_transfer' && $order->payment_status === 'unpaid')
                        <p class="mt-4 rounded-md bg-amber-50 p-3 text-xs leading-6 text-amber-900">
                            {{ \App\Models\Setting::where('key', 'bank_instructions')->value('value') ?: 'Please contact the store for bank transfer instructions. Do not send payment until verified.' }}
                        </p>
                    @endif
                </div>
                <div class="panel">
                    <h2 class="font-serif text-xl">Delivery Address</h2>
                    <p class="mt-4 text-sm leading-7 text-stone-600">
                        {{ $order->name }}<br>{{ $order->phone }}<br>{{ $order->address }}<br>{{ $order->city }}
                        {{ $order->postal_code }}</p>
                </div>
            </aside>
        </div>
    </div>
@endsection
