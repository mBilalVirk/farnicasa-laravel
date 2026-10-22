@extends('layouts.admin')
@section('title', 'Review Moderation')
@section('content')
    <h1 class="mb-7 font-serif text-4xl">
        Review Moderation</h1>
    <div class="panel !p-0 overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Customer</th>
                    <th>Rating</th>
                    <th>Review</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $r)
                    <tr>
                        <td>{{ $r->product?->name ?? 'Deleted product' }}</td>
                        <td>{{ $r->user?->name ?? 'Removed user' }}</td>
                        <td><span class="text-[#b49d57]">{{ str_repeat('★', $r->rating) }}</span></td>
                        <td class="max-w-md text-xs leading-6">{{ $r->comment }}</td>
                        <td>{{ $r->is_approved ? 'Approved' : 'Pending' }}</td>
                        <td>
                            <div class="flex gap-3">
                                <form action="{{ route('admin.reviews.approve', $r) }}" method="POST">@csrf
                                    @method('PATCH')<button
                                        class="text-olive underline">{{ $r->is_approved ? 'Hide' : 'Approve' }}</button>
                                </form>
                                <form action="{{ route('admin.reviews.destroy', $r) }}" method="POST"
                                    data-confirm="Permanently delete review?">@csrf @method('DELETE')<button
                                        class="text-red-600 underline">Delete</button></form>
                            </div>
                        </td>
                </tr>@empty<tr>
                        <td colspan="6">No reviews submitted.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-5">{{ $reviews->links() }}</div>
    </div>
@endsection
