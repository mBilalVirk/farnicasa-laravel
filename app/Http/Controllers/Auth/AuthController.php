<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function registerForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $request->merge(['email' => strtolower(trim((string) $request->input('email', '')))]);
        $data = $request->validate(['email' => ['required', 'email'], 'password' => ['required', 'string'], 'remember' => ['nullable', 'boolean']]);
        if (! Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'is_active' => true], (bool) ($data['remember'] ?? false))) {
            return back()->withErrors(['email' => 'These credentials are incorrect or this account is disabled.'])->onlyInput('email');
        }
        $request->session()->regenerate();

        return redirect()->intended(Auth::user()->isAdmin() ? route('admin.dashboard') : route('home'));
    }

    public function register(Request $request)
    {
        $request->merge(['email' => strtolower(trim((string) $request->input('email', '')))]);
        $data = $request->validate(['name' => ['required', 'string', 'max:120'], 'email' => ['required', 'email', 'max:190', 'unique:users,email'], 'password' => ['required', 'confirmed', Password::min(8)]]);
        $user = User::create(['name' => $data['name'], 'email' => strtolower($data['email']), 'password' => $data['password'], 'role' => 'customer']);
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Welcome to FurniCasa! Your account is ready.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
