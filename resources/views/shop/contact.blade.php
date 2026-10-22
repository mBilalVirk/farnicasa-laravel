@extends('layouts.store')
@section('title', 'Contact Us')
@section('content')
    <section class="bg-paper py-14">
        <div class="site-container">
            <p class="section-eyebrow">We are here to help</p>
            <h1 class="section-heading mt-2">Get in Touch</h1>
            <p class="mt-3 text-sm text-stone-600">Questions about a product, your order, or deliveries? Send us a message.
            </p>
        </div>
    </section>
    <div class="site-container grid gap-14 py-14 md:grid-cols-[minmax(0,1fr)_310px]">
        <form action="{{ route('contact.submit') }}" method="POST" class="space-y-5">@csrf<div
                class="grid gap-5 sm:grid-cols-2">
                <div><label class="field-label" for="name">Name</label><input class="field" name="name"
                        id="name" value="{{ old('name') }}" required></div>
                <div><label class="field-label" for="email">Email</label><input class="field" type="email"
                        name="email" id="email" value="{{ old('email') }}" required></div>
            </div>
            <div><label class="field-label" for="subject">Subject</label><input class="field" name="subject"
                    id="subject" value="{{ old('subject') }}" required></div>
            <div><label class="field-label" for="message">Message</label>
                <textarea class="field" name="message" id="message" rows="7" required>{{ old('message') }}</textarea>
            </div><button type="submit" class="btn-dark">Send Message →</button>
        </form>
        <aside class="bg-paper p-8">
            <h2 class="font-serif text-2xl">Contact Details</h2>
            <div class="mt-6 space-y-5 text-sm leading-7 text-stone-600">
                <p><b>Email</b><br>hello@furnicasa.com</p>
                <p><b>Phone</b><br>+1 234 567 8900</p>
                <p><b>Showroom</b><br>123 Furniture Street<br>New York, NY 10001</p>
                <p><b>Hours</b><br>Mon – Sat: 9:00 AM – 7:00 PM</p>
            </div>
        </aside>
    </div>
@endsection
