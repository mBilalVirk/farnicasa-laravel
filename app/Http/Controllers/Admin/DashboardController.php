<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = ['revenue' => Order::where('payment_status', 'paid')->where('status', '!=', 'cancelled')->sum('total'),
            'orders' => Order::count(), 'customers' => User::where('role', 'customer')->count(),
            'lowStock' => Product::whereColumn('stock', '<=', 'low_stock_threshold')->count()];
        $orders = Order::with('user')->latest()->take(8)->get();
        $lowStock = Product::whereColumn('stock', '<=', 'low_stock_threshold')->orderBy('stock')->take(6)->get();

        return view('admin.dashboard', compact('stats', 'orders', 'lowStock'));
    }
}
