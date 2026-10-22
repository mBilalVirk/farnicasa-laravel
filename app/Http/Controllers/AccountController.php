<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    public function index()
    {
        return view('account.dashboard', ['orders' => auth()->user()->orders()->latest()->limit(5)->get()]);
    }

    public function orders()
    {
        return view('account.orders', ['orders' => auth()->user()->orders()->latest()->paginate(10)]);
    }

    public function showOrder(Order $order)
    {
        abort_unless($order->user_id === auth()->id() || auth()->user()->isAdmin(), 403);

        return view('account.order', compact('order'));
    }

    public function profile()
    {
        return view('account.profile');
    }

    public function updateProfile(Request $request)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:120'], 'phone' => ['nullable', 'string', 'max:30'], 'address' => ['nullable', 'string', 'max:250'], 'city' => ['nullable', 'string', 'max:100'], 'postal_code' => ['nullable', 'string', 'max:20']]);
        $request->user()->update($data);

        return back()->with('success', 'Profile updated.');
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validate(['current_password' => ['required', 'current_password'], 'password' => ['required', 'confirmed', Password::min(8)]]);
        $request->user()->update(['password' => $data['password']]);

        return back()->with('success', 'Password changed.');
    }
}
