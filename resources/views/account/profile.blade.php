@extends('layouts.store')
@section('title', 'Profile Settings')
@section('content')
    <div class="site-container py-12">
        <h1 class="section-heading">Account Settings</h1>
        <div class="mt-8 grid gap-8 md:grid-cols-2">
            <form action="{{ route('account.profile.update') }}" method="POST" class="panel space-y-4">@csrf @method('PATCH')
                <h2 class="mb-5 font-serif text-2xl">My Details</h2>
                @foreach (['name' => 'Full name', 'phone' => 'Phone', 'address' => 'Address', 'city' => 'City', 'postal_code' => 'Postal code'] as $field => $label)
                    <div><label class="field-label" for="{{ $field }}">{{ $label }}</label><input class="field"
                            id="{{ $field }}" name="{{ $field }}"
                            value="{{ old($field, auth()->user()->$field) }}" {{ $field === 'name' ? 'required' : '' }}>
                    </div>
                @endforeach
                <button class="btn-dark">Save Changes</button>
            </form>
            <form action="{{ route('account.password.update') }}" method="POST" class="panel h-fit space-y-4">@csrf
                @method('PATCH')<h2 class="mb-5 font-serif text-2xl">Change Password</h2>
                <div><label class="field-label" for="current_password">Current password</label><input type="password"
                        id="current_password" name="current_password" class="field" required></div>
                <div><label class="field-label" for="password">New password</label><input type="password" id="password"
                        name="password" class="field" minlength="8" required></div>
                <div><label class="field-label" for="password_confirmation">Confirm new password</label><input
                        type="password" id="password_confirmation" name="password_confirmation" class="field"
                        minlength="8" required></div><button class="btn-dark">Update Password</button>
            </form>
        </div>
    </div>
@endsection
