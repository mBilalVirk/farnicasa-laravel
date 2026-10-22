@extends('layouts.admin')
@section('title', $category->exists ? 'Edit Category' : 'New Category')
@section('content')
    <a href="{{ route('admin.categories.index') }}" class="text-sm text-olive">
        <x-icon name="arrow-left" class="mr-1 inline h-4 w-4" />Back to Categories</a>
    <h1 class="my-6 font-serif text-4xl">{{ $category->exists ? 'Edit Category' : 'New Category' }}</h1>
    <form method="POST"
        action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
        class="panel max-w-2xl space-y-5">@csrf @if ($category->exists)
            @method('PUT')
        @endif
        <div><label class="field-label" for="name">Name *</label><input class="field" id="name" name="name"
                value="{{ old('name', $category->name) }}" required></div>
        <div><label class="field-label" for="description">Description</label>
            <textarea class="field" id="description" name="description" rows="4">{{ old('description', $category->description) }}</textarea>
        </div>
        <div><label class="field-label" for="image">Image URL</label><input type="url" class="field" id="image"
                name="image" value="{{ old('image', $category->image) }}"></div>
        <div><label class="field-label" for="sort_order">Sort order</label><input type="number" class="field"
                id="sort_order" name="sort_order" min="0" value="{{ old('sort_order', $category->sort_order ?? 0) }}"
                required></div><label class="flex gap-2 text-sm"><input type="checkbox" class="rounded text-olive"
                name="is_active" value="1"
                {{ old('is_active', $category->exists ? $category->is_active : true) ? 'checked' : '' }}>
            Active</label><button class="btn-dark">Save Category</button>
    </form>
@endsection
