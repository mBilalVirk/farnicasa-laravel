@extends('layouts.store')
@section('title','Shop Furniture')
@section('content')
<section class="bg-paper py-10"><div class="site-container"><p class="section-eyebrow">The FurniCasa Collection</p><h1 class="section-heading mt-2">Find Your Perfect Piece</h1><p class="mt-3 max-w-2xl text-sm text-stone-600">Timeless shapes. Thoughtful details. Every piece is designed to feel at home.</p></div></section>
<div class="site-container py-10" id="catalog"><div class="grid gap-9 lg:grid-cols-[235px_minmax(0,1fr)]">
 <aside><form method="GET" action="{{ route('shop') }}" class="space-y-6 rounded-md border border-stone-200 p-5 lg:border-0 lg:p-0">
  <div><label class="field-label" for="q">Search Furniture</label><input class="field" name="q" id="q" value="{{ request('q') }}" placeholder="Sofa, oak, dining..."></div>
  <div><p class="field-label mb-3">Categories</p><div class="space-y-3 text-sm"><label class="flex gap-2"><input type="radio" name="category" value="" {{ !request('category')?'checked':'' }} class="text-olive focus:ring-olive"> All Collections</label>@foreach($categories as $category)<label class="flex gap-2"><input type="radio" name="category" value="{{ $category->slug }}" {{ request('category')===$category->slug?'checked':'' }} class="text-olive focus:ring-olive"> {{ $category->name }}</label>@endforeach</div></div>
  <div><p class="field-label">Price range</p><div class="mt-3 flex items-center gap-2"><input class="field min-w-0" type="number" step="0.01" min="0" name="min" value="{{ request('min') }}" placeholder="Min"><span>–</span><input class="field min-w-0" type="number" step="0.01" min="0" name="max" value="{{ request('max') }}" placeholder="Max"></div></div>
  <div><label class="field-label" for="sort">Sort By</label><select name="sort" id="sort" class="field"><option value="">Newest Arrivals</option><option value="price_asc" {{ request('sort')==='price_asc'?'selected':'' }}>Price: Low to High</option><option value="price_desc" {{ request('sort')==='price_desc'?'selected':'' }}>Price: High to Low</option><option value="name" {{ request('sort')==='name'?'selected':'' }}>Name: A to Z</option></select></div>
  <button class="btn-dark w-full" type="submit">Apply Filters →</button><a href="{{ route('shop') }}" class="block text-center text-xs underline text-stone-500">Clear filters</a>
 </form></aside>
 <div><div class="mb-6 flex items-center justify-between"><p class="text-sm text-stone-600">Showing {{ $products->total() }} products</p><p class="text-xs text-olive">Made for living beautifully</p></div>
  @if($products->isEmpty())<div class="rounded-md bg-paper p-16 text-center"><h2 class="font-serif text-3xl">No products found</h2><p class="mt-3 text-sm text-muted">Try changing your filters.</p><a class="btn-dark mt-5" href="{{ route('shop') }}">Browse All</a></div>
  @else<div class="grid grid-cols-2 gap-5 md:grid-cols-3 xl:grid-cols-4">@foreach($products as $product)@include('partials.product-card',['product'=>$product])@endforeach</div><div class="mt-10">{{ $products->links() }}</div>@endif
 </div></div></div>
@endsection
