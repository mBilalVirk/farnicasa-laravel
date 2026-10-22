@extends('layouts.store')
@section('title', 'Create Account')
@section('content')
    <section class="bg-paper py-16">
        <div class="mx-auto max-w-md px-5">
            <div class="border border-stone-200 bg-white p-8 shadow-soft">
                <p class="section-eyebrow">Join the family</p>
                <h1 class="mt-2 font-serif text-4xl">Create Account</h1>
                <form action="{{ route('register') }}" method="POST" class="mt-8 space-y-5">@csrf<div><label
                            class="field-label" for="name">Full Name</label><input class="field" name="name"
                            id="name" value="{{ old('name') }}" required></div>
                    <div><label class="field-label" for="email">Email Address</label><input class="field" type="email"
                            name="email" id="email" value="{{ old('email') }}" required></div>
                    <div><label class="field-label" for="password">Password</label><input class="field" type="password"
                            name="password" id="password" minlength="8" required></div>
                    <div><label class="field-label" for="password_confirmation">Confirm Password</label><input
                            class="field" type="password" name="password_confirmation" id="password_confirmation"
                            minlength="8" required></div><button class="btn-dark w-full">Create Account →</button>
                </form>
                <p class="mt-6 text-center text-sm text-stone-500">Already a member? <a
                        class="font-bold text-olive underline" href="{{ route('login') }}">Sign in</a></p>
            </div>
        </div>
    </section>
@endsection
