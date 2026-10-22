<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Support\Collection;

class CartService
{
    public function quantities(): array
    {
        return session('cart', []);
    }

    public function items(): Collection
    {
        $cart = $this->quantities();
        if (! $cart) {
            return collect();
        }

        return Product::whereIn('id', array_keys($cart))->where('is_active', true)->get()->map(fn (Product $product) => (object) [
            'product' => $product, 'quantity' => max(1, (int) ($cart[$product->id] ?? 1)),
            'line_total' => round((float) $product->price * max(1, (int) ($cart[$product->id] ?? 1)), 2),
        ]);
    }

    public function summary(): array
    {
        $items = $this->items();
        $subtotal = round($items->sum('line_total'), 2);
        $coupon = null;
        $discount = 0;
        if ($code = session('coupon_code')) {
            $coupon = Coupon::where('code', $code)->first();
            if ($coupon && $coupon->usableFor($subtotal)) {
                $discount = $coupon->discount($subtotal);
            } else {
                $coupon = null;
            }
        }
        $shipping = $subtotal > 0 && $subtotal < (float) config('store.shipping_threshold') ? (float) config('store.shipping_fee') : 0;
        $tax = round(max(0, $subtotal - $discount) * (float) config('store.tax_rate') / 100, 2);

        return compact('items', 'subtotal', 'coupon', 'discount', 'shipping', 'tax') + ['total' => round($subtotal - $discount + $shipping + $tax, 2)];
    }

    public function count(): int
    {
        return array_sum($this->quantities());
    }
}
