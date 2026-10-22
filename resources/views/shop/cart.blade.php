@extends('layouts.store')
@section('title', 'Your Cart')
@section('content')
    <div class="site-container py-12">
        <h1 class="section-heading mb-8">Your Shopping Cart</h1>
        @if ($items->isEmpty())
            <div class="bg-paper px-8 py-20 text-center">
                <h2 class="font-serif text-3xl">Your cart is empty</h2>
                <p class="mt-3 text-sm text-stone-500">A beautiful space starts with something you love.</p><a
                    href="{{ route('shop') }}" class="btn-dark mt-6">Continue Shopping</a>
            </div>
        @else<div class="grid gap-10 lg:grid-cols-[minmax(0,1fr)_350px]">
                <div>
                    <form id="cart-update" action="{{ route('cart.update') }}" method="POST">@csrf @method('PATCH')<div
                            class="overflow-x-auto">
                            <table class="w-full min-w-[520px] text-left">
                                <thead>
                                    <tr class="border-b border-stone-300 text-xs uppercase tracking-wider text-stone-500">
                                        <th class="pb-4">Product</th>
                                        <th class="pb-4">Price</th>
                                        <th class="pb-4">Quantity</th>
                                        <th class="pb-4 text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr class="border-b border-stone-200">
                                            <td class="py-5">
                                                <div class="flex items-center gap-4"><a
                                                        href="{{ route('products.show', $item->product) }}"><img
                                                            class="h-20 w-20 object-cover"
                                                            src="{{ $item->product->image_url }}"
                                                            alt="{{ $item->product->name }}"></a>
                                                    <div><a class="font-semibold"
                                                            href="{{ route('products.show', $item->product) }}">{{ $item->product->name }}</a>
                                                        <p class="mt-1 text-xs text-muted">{{ $item->product->sku }}</p>
                                                        <button class="mt-2 text-xs text-red-600 underline" type="submit"
                                                            form="remove-{{ $item->product->id }}">Remove</button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-sm">${{ number_format($item->product->price, 2) }}</td>
                                            <td><input aria-label="Quantity for {{ $item->product->name }}"
                                                    name="quantities[{{ $item->product->id }}]" type="number"
                                                    min="0" max="{{ min($item->product->stock, 99) }}"
                                                    class="w-20 rounded-md border-stone-300 text-sm"
                                                    value="{{ $item->quantity }}"></td>
                                            <td class="text-right font-semibold">${{ number_format($item->line_total, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6 flex items-center justify-between"><a href="{{ route('shop') }}"
                                class="text-sm underline underline-offset-4"><x-icon name="arrow-left"
                                    class="mr-1 inline h-4 w-4" />Continue shopping</a><button type="submit"
                                class="btn-outline">Update Cart</button></div>
                    </form>
                    @foreach ($items as $item)
                        <form id="remove-{{ $item->product->id }}" method="POST"
                            action="{{ route('cart.remove', $item->product) }}">@csrf @method('DELETE')</form>
                    @endforeach
                </div>
                <aside class="h-fit bg-paper p-7">
                    <h2 class="font-serif text-2xl">Order Summary</h2>
                    <div class="mt-6 space-y-4 border-b border-stone-200 pb-6 text-sm">
                        <div class="flex justify-between">
                            <span>Subtotal</span><span>${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Discount</span><span>−${{ number_format($discount, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Shipping</span><span>{{ $shipping ? '$' . number_format($shipping, 2) : 'FREE' }}</span>
                        </div>
                        <div class="flex justify-between"><span>Tax</span><span>${{ number_format($tax, 2) }}</span></div>
                    </div>
                    <div class="mt-5 flex justify-between font-bold"><span>Total</span><span
                            class="text-xl">${{ number_format($total, 2) }}</span></div>
                    @if ($coupon)
                        <form class="mt-5" action="{{ route('cart.coupon.remove') }}" method="POST">@csrf
                            @method('DELETE')<button class="text-xs text-olive underline">Coupon {{ $coupon->code }}
                            applied — remove</button></form>@else<form class="mt-5 flex gap-2"
                            action="{{ route('cart.coupon') }}" method="POST">@csrf<input name="code"
                                class="field min-w-0 flex-1 uppercase" placeholder="Promo code"><button
                                class="btn-outline !px-3">Apply</button></form>
                    @endif
                    <a href="{{ route('checkout.index') }}" class="btn-dark mt-7 w-full">Proceed to Checkout <x-icon
                            name="arrow-right" class="h-4 w-4" /></a>
                    <p class="mt-4 text-center text-xs text-stone-500">Taxes and shipping calculated above.</p>
                </aside>
            </div>
        @endif
    </div>
@endsection
