@extends('layouts.store')
@section('title', 'Secure Checkout')
@section('content')
    <div class="site-container py-12">
        <h1 class="section-heading mb-8">Checkout</h1>
        <form method="POST" action="{{ route('checkout.place') }}" class="grid gap-10 lg:grid-cols-[minmax(0,1fr)_350px]">
            @csrf
            <div class="space-y-7">
                <section class="border border-stone-200 p-6 sm:p-8">
                    <h2 class="mb-6 font-serif text-2xl">Delivery Information</h2>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div><label for="name" class="field-label">Full name *</label><input class="field"
                                id="name" name="name" required value="{{ old('name', auth()->user()->name) }}">
                        </div>
                        <div><label for="email" class="field-label">Email *</label><input class="field" type="email"
                                id="email" name="email" required value="{{ old('email', auth()->user()->email) }}">
                        </div>
                        <div><label for="phone" class="field-label">Phone *</label><input class="field" id="phone"
                                name="phone" required value="{{ old('phone', auth()->user()->phone) }}"></div>
                        <div><label for="city" class="field-label">City *</label><input class="field" id="city"
                                name="city" required value="{{ old('city', auth()->user()->city) }}"></div>
                        <div class="sm:col-span-2"><label for="address" class="field-label">Street Address *</label><input
                                class="field" id="address" name="address" required
                                value="{{ old('address', auth()->user()->address) }}"></div>
                        <div><label for="postal_code" class="field-label">Postal code</label><input class="field"
                                id="postal_code" name="postal_code"
                                value="{{ old('postal_code', auth()->user()->postal_code) }}"></div>
                        <div class="sm:col-span-2"><label for="notes" class="field-label">Order notes (optional)</label>
                            <textarea class="field" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </section>
                <section class="border border-stone-200 p-6 sm:p-8">
                    <h2 class="mb-6 font-serif text-2xl">Payment Method</h2>
                    <div class="space-y-4"><label
                            class="flex cursor-pointer gap-3 rounded-md border border-stone-200 p-4"><input type="radio"
                                name="payment_method" value="cod"
                                {{ old('payment_method', 'cod') === 'cod' ? 'checked' : '' }} class="mt-1 text-olive"
                                required><span><strong class="block text-sm">Cash on
                                    Delivery</strong><small class="mt-1 block text-stone-500">Pay when your furniture
                                    arrives.</small></span></label><label
                            class="flex cursor-pointer gap-3 rounded-md border border-stone-200 p-4"><input type="radio"
                                name="payment_method" value="bank_transfer"
                                {{ old('payment_method') === 'bank_transfer' ? 'checked' : '' }}
                                class="mt-1 text-olive"><span><strong class="block text-sm">Manual Bank
                                    Transfer</strong><small class="mt-1 block text-stone-500">Instructions will be displayed
                                    with your order. Your order remains unpaid until confirmed by the
                                    store.</small></span></label></div>
                </section>
            </div>
            <aside class="h-fit bg-paper p-7">
                <h2 class="font-serif text-2xl">Your Order</h2>
                <div class="mt-5 space-y-4">
                    @foreach ($items as $item)
                        <div class="flex items-center gap-3"><img class="h-16 w-16 object-cover"
                                src="{{ $item->product->image_url }}" alt="">
                            <div class="flex-1 text-xs">
                                <p class="font-semibold">{{ $item->product->name }}</p>
                                <p class="text-stone-500">Qty: {{ $item->quantity }}</p>
                            </div><strong class="text-sm">${{ number_format($item->line_total, 2) }}</strong>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 space-y-3 border-t border-stone-300 pt-5 text-sm">
                    <div class="flex justify-between"><span>Subtotal</span><span>${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between"><span>Discount</span><span>−${{ number_format($discount, 2) }}</span>
                    </div>
                    <div class="flex justify-between"><span>Shipping</span><span>${{ number_format($shipping, 2) }}</span>
                    </div>
                    <div class="flex justify-between"><span>Tax</span><span>${{ number_format($tax, 2) }}</span></div>
                    <div class="flex justify-between border-t border-stone-200 pt-4 text-lg font-bold">
                        <span>Total</span><span>${{ number_format($total, 2) }}</span>
                    </div>
                </div><button class="btn-dark mt-7 w-full">Place Order →</button>
                <p class="mt-3 text-xs leading-5 text-stone-500">By placing your order you agree to be contacted regarding
                    your delivery.</p>
            </aside>
        </form>
    </div>
@endsection
