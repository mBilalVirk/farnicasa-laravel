@extends('layouts.admin')
@section('title', 'Order ' . $order->order_number)
@section('content')
    <div class="mb-7">
        <a href="{{ route('admin.orders.index') }}" class="text-sm text-olive">← Back to Orders</a>
        <h1 class="mt-2 font-serif text-4xl">{{ $order->order_number }}</h1>
        <p class="mt-2 text-sm text-muted">Placed {{ $order->created_at->format('F j, Y g:i A') }}</p>
    </div>
    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_350px]">
        <div class="space-y-6">
            <div class="panel">
                <h2 class="font-serif text-2xl">Items</h2>
                <div class="mt-5 overflow-x-auto">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->sku }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->unit_price, 2) }}</td>
                                    <td>${{ number_format($item->line_total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-5 ml-auto max-w-xs space-y-2 text-sm">
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
                    <div class="flex justify-between border-t pt-3 font-bold"><span>Grand
                            Total</span><span>${{ number_format($order->total, 2) }}</span></div>
                </div>
            </div>
            <div class="panel">
                <h2 class="font-serif text-2xl">Delivery Details</h2>
                <p class="mt-4 text-sm leading-8 text-stone-600">{{ $order->name }} ·
                    {{ $order->email }}<br>{{ $order->phone }}<br>{{ $order->address }}<br>{{ $order->city }},
                    {{ $order->postal_code }}</p>
                @if ($order->notes)
                    <p class="mt-4 bg-paper p-3 text-sm">Note: {{ $order->notes }}</p>
                @endif
            </div>
        </div>
        <div class="panel h-fit">
            <h2 class="font-serif text-2xl">Update Order</h2>
            <p class="mt-3 text-xs text-stone-500">Status changes are validated. Cancelling restocks products exactly once.
                Shipped/delivered orders cannot be cancelled here.</p>
            <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="mt-6 space-y-5">@csrf
                @method('PATCH')<div><label for="status" class="field-label">Order status</label><select class="field"
                        id="status" name="status">
                        @foreach (['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                            <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}</option>
                        @endforeach
                    </select></div>
                <div><label for="payment_status" class="field-label">Payment status</label><select class="field"
                        id="payment_status" name="payment_status">
                        <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid — manually
                            confirmed</option>
                    </select></div>
                <p class="text-xs text-muted">Payment method:
                    <b>{{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Bank Transfer' }}</b>
                </p><button class="btn-dark w-full">Save Order Changes</button>
            </form>
        </div>
    </div>
@endsection
