@extends('layouts.store')
@section('title', 'Beautiful Furniture for Every Space')
@section('content')
    <section class="relative min-h-[420px] bg-[#eae7df] lg:min-h-[520px]">
        <div class="absolute inset-0 hero-cover"
            style="background-image:linear-gradient(90deg,rgba(246,244,238,.98) 0%,rgba(246,244,238,.96) 21%,rgba(246,244,238,.64) 39%,rgba(246,244,238,.06) 64%),url('https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?auto=format&fit=crop&w=2000&q=85')">
        </div>
        <div class="site-container relative flex min-h-[420px] items-center lg:min-h-[520px]">
            <div class="max-w-[540px] py-12">
                <p class="section-eyebrow mb-4">Modern Living, Perfectly Designed</p>
                <h1 class="font-serif text-5xl leading-[1.10] sm:text-6xl xl:text-[70px]">Furniture That <br>Defines Your
                    Space</h1>
                <p class="mt-5 max-w-[345px] text-sm leading-7 text-stone-700">Discover a wide range of stylish, comfortable,
                    and durable furniture pieces crafted for every room.</p>
                <div class="mt-7 flex flex-wrap gap-3"><a href="{{ route('shop') }}" class="btn-dark">Shop Collection <x-icon
                            name="arrow-right" class="h-4 w-4" /></a><a href="#sale" class="btn-outline">Explore Deals</a>
                </div>
                <div class="mt-10 flex flex-wrap gap-5 text-[11px] sm:gap-8">
                    <div class="flex items-center gap-2"><x-icon name="truck" class="h-6 w-6 text-olive" /><span><strong
                                class="block">Free
                                Shipping</strong><span class="text-stone-500">On orders $499+</span></span></div>
                    <div class="flex items-center gap-2"><x-icon name="clock" class="h-6 w-6 text-olive" /><span><strong
                                class="block">30-Day
                                Returns</strong><span class="text-stone-500">Hassle-free returns</span></span></div>
                    <div class="flex items-center gap-2"><x-icon name="shield" class="h-6 w-6 text-olive" /><span><strong
                                class="block">Secure
                                Checkout</strong><span class="text-stone-500">Protected ordering</span></span></div>
                </div>
            </div>
        </div>
    </section>
    <section class="site-container py-12 sm:py-16">
        <p class="mb-7 text-center text-[11px] font-semibold uppercase tracking-widest">Shop by Category</p>
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6 lg:gap-4">
            @foreach ($categories as $category)
                <a href="{{ route('categories.show', $category) }}" class="group text-center">
                    <div class="overflow-hidden bg-cream"><img loading="lazy" src="{{ $category->image_url }}"
                            alt="{{ $category->name }} furniture"
                            class="category-photo transition duration-500 group-hover:scale-105"></div>
                    <h3 class="mt-3 text-sm font-semibold">{{ $category->name }}</h3>
                    <p class="mt-1 text-[11px] text-stone-500">{{ $category->products_count }} Products</p>
                </a>
            @endforeach
        </div>
    </section>
    <section id="sale" class="site-container pb-12 sm:pb-16">
        <div class="relative flex min-h-[245px] overflow-hidden bg-[#edeae3]">
            <div class="absolute inset-0"
                style="background-image:url('https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1700&q=85');background-size:cover;background-position:center;">
            </div>
            <div class="absolute inset-0 bg-white/40"></div>
            <div class="relative mx-auto flex max-w-[560px] flex-col items-center justify-center px-5 py-9 text-center">
                <p class="section-eyebrow">Seasonal Special Offers</p>
                <h2 class="mt-3 font-serif text-4xl sm:text-5xl">Up to 40% Off</h2>
                <p class="mt-1 font-serif text-xl">On Selected Items</p>
                <p class="mt-3 text-xs">Transform your space for less.</p><a
                    href="{{ route('shop', ['sort' => 'price_asc']) }}" class="btn-dark mt-5 !px-5 !py-2.5 !text-xs">Shop
                    the
                    Sale <x-icon name="arrow-right" class="ml-1 inline h-4 w-4" /></a>
            </div>
        </div>
    </section>
    <section class="site-container pb-14">
        <div class="mb-6 flex items-end justify-between">
            <div>
                <p class="section-eyebrow">Handpicked for You</p>
                <h2 class="mt-2 section-heading">Best Sellers</h2>
            </div><a href="{{ route('shop') }}"
                class="text-xs font-semibold underline underline-offset-4 hover:text-olive">View All Products <x-icon
                    name="arrow-right" class="inline h-4 w-4" /></a>
        </div>
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6 lg:gap-5">
            @foreach ($featured as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </section>
    <section class="bg-[#f9f8f5] py-9">
        <div class="site-container grid grid-cols-2 gap-8 md:grid-cols-4">
            @foreach ([['package', 'Premium Quality', 'Carefully crafted for durability & comfort'], ['tag', 'Affordable Prices', 'Beautiful furniture at unbeatable prices'], ['headset', 'Expert Support', 'We are here to help before & after purchase'], ['recycle', 'Sustainable Choice', 'Thoughtful materials for a better tomorrow']] as $feature)
                <div class="flex items-start gap-3"><x-icon :name="$feature[0]" class="mt-1 h-6 w-6 shrink-0 text-olive" />
                    <div>
                        <h3 class="text-xs font-bold">{{ $feature[1] }}</h3>
                        <p class="mt-1 text-xs leading-5 text-stone-500">{{ $feature[2] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    <section class="site-container py-12 sm:py-16">
        <p class="section-eyebrow text-center">Your Home, Your Story</p>
        <h2 class="section-heading mt-2 text-center">Made for Moments That Matter</h2>
        <div class="mt-8 grid gap-5 md:grid-cols-3">
            <div class="bg-cream"><img loading="lazy" class="h-48 w-full object-cover"
                    src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=750&q=80"
                    alt="Beautiful neutral living room">
                <div class="p-5">
                    <h3 class="font-serif text-xl">Live in Comfort</h3>
                    <p class="mt-2 text-sm text-stone-600">Relax in rooms that feel like you.</p>
                </div>
            </div>
            <div class="bg-cream"><img loading="lazy" class="h-48 w-full object-cover"
                    src="https://images.unsplash.com/photo-1616594039964-ae9021a400a0?auto=format&fit=crop&w=750&q=80"
                    alt="Peaceful bedroom">
                <div class="p-5">
                    <h3 class="font-serif text-xl">Rest Beautifully</h3>
                    <p class="mt-2 text-sm text-stone-600">Find your perfect place to unwind.</p>
                </div>
            </div>
            <div class="bg-cream"><img loading="lazy" class="h-48 w-full object-cover"
                    src="https://images.unsplash.com/photo-1617806118233-18e1de247200?auto=format&fit=crop&w=750&q=80"
                    alt="Contemporary dining area">
                <div class="p-5">
                    <h3 class="font-serif text-xl">Gather Together</h3>
                    <p class="mt-2 text-sm text-stone-600">Create memories around the table.</p>
                </div>
            </div>
        </div>
    </section>
    @if ($testimonials->isNotEmpty())
        <section class="site-container py-12">
            <p class="section-eyebrow text-center">From Verified Purchases</p>
            <h2 class="section-heading mt-2 text-center">What Our Customers Say</h2>
            <div class="mt-8 grid gap-5 md:grid-cols-3">
                @foreach ($testimonials as $review)
                    <div class="bg-paper p-7">
                        <p class="flex text-[#b59c51]" aria-label="Rated {{ $review->rating }} out of 5">
                            @for ($star = 0; $star < $review->rating; $star++)
                                <x-icon name="star" class="h-4 w-4" filled />
                            @endfor
                        </p>
                        <p class="mt-4 text-sm leading-7 text-stone-700">“{{ $review->comment }}”</p>
                        <p class="mt-5 text-xs font-bold">{{ $review->user->name }}</p>
                        <p class="mt-1 text-xs text-muted">Purchased: {{ $review->product->name }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
    <section class="site-container pb-14">
        <div class="flex flex-col items-center justify-between gap-5 bg-[#f0eee9] p-8 md:flex-row md:px-12">
            <div>
                <p class="font-serif text-2xl">Stay Inspired</p>
                <p class="mt-1 text-xs leading-5 text-stone-600">Subscribe to get special offers, design inspiration and
                    new arrivals.</p>
            </div>
            <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex w-full max-w-md gap-2">
                @csrf<label for="newsletter" class="sr-only">Email address</label><input id="newsletter" name="email"
                    type="email" required class="field flex-1 !rounded-none"
                    placeholder="Enter your email address"><button class="btn-dark !px-5"
                    type="submit">Subscribe</button></form>
        </div>
    </section>
@endsection
