<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\InventoryMovement;
use App\Models\Order;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function index(CartService $cart)
    {
        $summary = $cart->summary();
        if ($summary['items']->isEmpty()) {
            return redirect()->route('cart.index');
        }

return view('shop.checkout', $summary);
    }

    public function place(Request $request)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:120'], 'email' => ['required', 'email', 'max:190'],
            'phone' => ['required', 'string', 'max:30'], 'address' => ['required', 'string', 'max:250'], 'city' => ['required', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'], 'notes' => ['nullable', 'string', 'max:1000'],
            'payment_method' => ['required', 'in:cod,bank_transfer']]);
        $quantities = session('cart', []);
        if (empty($quantities)) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Your cart is empty.']);
        }
        $order = DB::transaction(function () use ($quantities, $data) {
            $products = Product::whereIn('id', array_keys($quantities))->lockForUpdate()->get()->keyBy('id');
            if ($products->count() !== count($quantities)) {
                throw ValidationException::withMessages(['cart' => 'Some cart items are no longer available. Please refresh your cart.']);
            }
            $subtotal = 0;
            $lines = [];
            foreach ($quantities as $id => $quantity) {
                $quantity = (int) $quantity;
                $product = $products->get($id);
                if (! $product || ! $product->is_active || $quantity < 1 || $quantity > 99 || $product->stock < $quantity) {
                    throw ValidationException::withMessages(['cart' => 'Some items have insufficient stock. Please update your cart.']);
                }
                $line = round((float) $product->price * $quantity, 2);
                $subtotal += $line;
                $lines[] = ['product' => $product, 'quantity' => $quantity, 'total' => $line];
            }
            $coupon = null;
            $discount = 0;
            if ($code = session('coupon_code')) {
                $coupon = Coupon::where('code', $code)->lockForUpdate()->first();
                if (! $coupon || ! $coupon->usableFor($subtotal)) {
                    throw ValidationException::withMessages(['coupon' => 'Coupon is no longer valid. Remove it from your cart and try again.']);
                }
                $discount = $coupon->discount($subtotal);
            }
            $shipping = $subtotal < (float) config('store.shipping_threshold') ? (float) config('store.shipping_fee') : 0;
            $tax = round(max(0, $subtotal - $discount) * (float) config('store.tax_rate') / 100, 2);
            $order = Order::create(array_merge($data, [
                'order_number' => 'FC-'.now()->format('ymd').'-'.strtoupper(Str::random(8)),
                'user_id' => auth()->id(), 'coupon_id' => $coupon?->id, 'status' => 'pending', 'payment_status' => 'unpaid',
                'subtotal' => round($subtotal, 2), 'discount' => $discount, 'shipping' => $shipping, 'tax' => $tax, 'total' => round($subtotal - $discount + $shipping + $tax, 2),
            ]));
            foreach ($lines as $line) {
                $p = $line['product'];
                $order->items()->create(['product_id' => $p->id, 'product_name' => $p->name, 'sku' => $p->sku, 'unit_price' => $p->price, 'quantity' => $line['quantity'], 'line_total' => $line['total']]);
                $p->decrement('stock', $line['quantity']);
                InventoryMovement::create(['product_id' => $p->id, 'user_id' => auth()->id(), 'order_id' => $order->id, 'change' => -$line['quantity'], 'stock_after' => $p->fresh()->stock, 'reason' => 'sale']);
            }
            if ($coupon) {
                $coupon->increment('used_count');
            }

            return $order;
        }, 3);
        session()->forget(['cart', 'coupon_code']);

        return redirect()->route('account.orders.show', $order)->with('success','Your order was placed successfully!');
    }
}
