@extends('layouts.admin')
@section('title', $product->exists ? 'Edit Product' : 'New Product')
@section('content')
    <div class="mb-7">
        <a class="text-sm text-olive" href="{{ route('admin.products.index') }}">← Back to Products</a>
        <h1 class="mt-2 font-serif text-4xl">{{ $product->exists ? 'Edit Product' : 'Create Product' }}</h1>
    </div>
    <form method="POST" enctype="multipart/form-data"
        action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}"
        class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px]">@csrf @if ($product->exists)
            @method('PUT')
        @endif
        <div class="panel space-y-5">
            <h2 class="font-serif text-2xl">Product Information</h2>
            <div><label class="field-label" for="name">Name *</label><input class="field" id="name" name="name"
                    value="{{ old('name', $product->name) }}" required></div>
            <div class="grid gap-5 sm:grid-cols-2">
                <div><label class="field-label" for="sku">SKU *</label><input class="field" id="sku"
                        name="sku" value="{{ old('sku', $product->sku) }}" required></div>
                <div><label class="field-label" for="category_id">Category *</label><select class="field" id="category_id"
                        name="category_id" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div><label class="field-label" for="description">Description</label>
                <textarea class="field" id="description" name="description" rows="7">{{ old('description', $product->description) }}</textarea>
            </div>
            <div class="grid gap-5 sm:grid-cols-2">
                <div><label class="field-label" for="price">Price ($) *</label><input class="field" type="number"
                        min="0" step="0.01" id="price" name="price"
                        value="{{ old('price', $product->price) }}" required></div>
                <div><label class="field-label" for="compare_at_price">Compare-at Price ($)</label><input class="field"
                        type="number" min="0" step="0.01" id="compare_at_price" name="compare_at_price"
                        value="{{ old('compare_at_price', $product->compare_at_price) }}"></div>
            </div>
            <div class="grid gap-5 sm:grid-cols-2">
                <div><label class="field-label" for="material">Material</label><input class="field" id="material"
                        name="material" value="{{ old('material', $product->material) }}"></div>
                <div><label class="field-label" for="dimensions">Dimensions</label><input class="field" id="dimensions"
                        name="dimensions" value="{{ old('dimensions', $product->dimensions) }}"></div>
            </div>
        </div>
        <div class="space-y-6">
            <div class="panel space-y-5">
                <h2 class="font-serif text-2xl">Media</h2>
                @if ($product->image)
                    <img src="{{ $product->image_url }}" class="h-36 w-full object-cover" alt="Current product image">
                @endif
                <div>
                    <label class="field-label" for="image">Image URL</label><input class="field" type="url"
                        id="image" name="image"
                        value="{{ old('image', str_starts_with($product->image ?? '', 'http') ? $product->image : '') }}"
                        placeholder="https://...">
                </div>
                <div><label class="field-label" for="image_file">Or upload image</label><input class="block w-full text-xs"
                        type="file" id="image_file" name="image_file" accept="image/*">
                    <p class="mt-2 text-xs text-stone-500">JPEG, PNG, WebP. Max 3 MB.</p>
                </div>
            </div>
            <div class="panel space-y-5">
                <h2 class="font-serif text-2xl">Inventory & Visibility</h2>
                @if (!$product->exists)
                    <div><label class="field-label" for="stock">Opening Stock *</label><input class="field"
                            id="stock" name="stock" type="number" min="0" value="{{ old('stock', 10) }}"
                        required></div>@else<p class="text-sm text-stone-600">Current stock:
                        <b>{{ $product->stock }}</b><br>Adjust stock in <a class="underline text-olive"
                            href="{{ route('admin.inventory.index') }}">Inventory Management</a>.
                    </p>
                @endif
                <div><label class="field-label" for="low_stock_threshold">Low Stock Alert At</label><input class="field"
                        id="low_stock_threshold" name="low_stock_threshold" type="number" min="0"
                        value="{{ old('low_stock_threshold', $product->low_stock_threshold ?? 5) }}" required></div><label
                    class="flex gap-2 text-sm"><input class="rounded text-olive" type="checkbox" name="is_active"
                        value="1"
                        {{ old('is_active', $product->exists ? $product->is_active : true) ? 'checked' : '' }}>
                    Visible on storefront</label><label class="flex gap-2 text-sm"><input class="rounded text-olive"
                        type="checkbox" name="is_featured" value="1"
                        {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}> Featured product</label>
            </div><button class="btn-dark w-full">{{ $product->exists ? 'Save Changes' : 'Create Product' }} →</button>
        </div>
    </form>
@endsection
