@extends('layouts.admin')
@section('title', 'Products')
@section('content')
    <div class="mb-7 flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="section-eyebrow">Catalog Management</p>
            <h1 class="mt-1 font-serif text-4xl">Products</h1>
        </div><a href="{{ route('admin.products.create') }}" class="btn-dark">+ New Product</a>
    </div>
    <div class="panel !p-0">
        <form class="flex flex-wrap gap-3 p-5" method="GET"><input class="field max-w-sm" name="q"
                value="{{ request('q') }}" placeholder="Search name or SKU"><select class="field max-w-[180px]"
                name="stock">
                <option value="">All stock</option>
                <option value="low" {{ request('stock') === 'low' ? 'selected' : '' }}>Low stock only</option>
            </select><button class="btn-dark">Filter</button><a href="{{ route('admin.products.index') }}"
                class="btn-outline">Reset</a></form>
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Visible</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $p)
                        <tr>
                            <td>
                                <div class="flex min-w-[180px] items-center gap-3"><img src="{{ $p->image_url }}"
                                        alt="" class="h-12 w-12 object-cover"><span
                                        class="font-semibold">{{ $p->name }}</span></div>
                            </td>
                            <td>{{ $p->sku }}</td>
                            <td>{{ $p->category?->name }}</td>
                            <td>${{ number_format($p->price, 2) }}</td>
                            <td><span
                                    class="{{ $p->is_low_stock ? 'font-bold text-red-600' : 'text-emerald-700' }}">{{ $p->stock }}</span>
                            </td>
                            <td>{{ $p->is_active ? 'Yes' : 'No' }}</td>
                            <td>
                                <div class="flex items-center gap-3"><a class="text-olive underline"
                                        href="{{ route('admin.products.edit', $p) }}">Edit</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $p) }}"
                                        data-confirm="Delete this product? Product order history will be retained.">@csrf
                                        @method('DELETE')<button class="text-red-600 underline">Delete</button></form>
                                </div>
                            </td>
                    </tr>@empty<tr>
                            <td colspan="7">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-5">{{ $products->links() }}</div>
    </div>
@endsection
