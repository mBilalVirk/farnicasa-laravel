@extends('layouts.store')
@section('title','My Orders')
@section('content')
<div class="site-container py-12"><h1 class="section-heading mb-7">My Orders</h1><div class="overflow-x-auto"><table class="admin-table"><thead><tr><th>Order Number</th><th>Placed</th><th>Status</th><th>Payment</th><th>Total</th><th></th></tr></thead><tbody>@forelse($orders as $order)<tr><td class="font-semibold">{{ $order->order_number }}</td><td>{{ $order->created_at->format('M d, Y') }}</td><td><span class="status-pill">{{ $order->status }}</span></td><td>{{ ucfirst($order->payment_status) }}</td><td>${{ number_format($order->total,2) }}</td><td><a class="text-olive underline" href="{{ route('account.orders.show',$order) }}">View</a></td></tr>@empty<tr><td colspan="6">You haven't placed any orders yet.</td></tr>@endforelse</tbody></table></div><div class="mt-6">{{ $orders->links() }}</div></div>
@endsection
