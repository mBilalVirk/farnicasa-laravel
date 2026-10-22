@extends('layouts.admin')
@section('title', 'Categories')
@section('content')
    <div class="mb-7 flex items-center justify-between gap-4">
        <h1 class="font-serif text-4xl">Categories</h1><a href="{{ route('admin.categories.create') }}" class="btn-dark">+ Add
            Category</a>
    </div>
    <div class="panel overflow-x-auto !p-0">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Products</th>
                    <th>Sort</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3"><img class="h-14 w-20 object-cover"
                                    src="{{ $category->image_url }}" alt=""><b>{{ $category->name }}</b></div>
                        </td>
                        <td>{{ $category->products_count }}</td>
                        <td>{{ $category->sort_order }}</td>
                        <td>{{ $category->is_active ? 'Yes' : 'No' }}</td>
                        <td>
                            <div class="flex gap-4"><a class="text-olive underline"
                                    href="{{ route('admin.categories.edit', $category) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                    data-confirm="Delete category?">@csrf @method('DELETE')<button
                                        class="text-red-600 underline">Delete</button></form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
