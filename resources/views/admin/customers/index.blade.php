@extends('layouts.admin')
@section('title', 'Customers')
@section('content')
    <h1 class="mb-7 font-serif text-4xl">
        Customers</h1>
    <div class="panel !p-0">
        <form class="flex gap-3 p-5" method="GET"><input class="field max-w-sm" name="q" value="{{ request('q') }}"
                placeholder="Search customer"><button class="btn-dark">Find</button></form>
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Orders</th>
                        <th>Joined</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $u)
                        <tr>
                            <td class="font-semibold">{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->phone ?? '—' }}</td>
                            <td>{{ $u->orders_count }}</td>
                            <td>{{ $u->created_at->format('M d, Y') }}</td>
                            <td>{{ $u->is_active ? 'Active' : 'Disabled' }}</td>
                            <td>
                                <form action="{{ route('admin.customers.toggle', $u) }}" method="POST"
                                    data-confirm="Change customer account status?">@csrf @method('PATCH')<button
                                        class="text-olive underline">{{ $u->is_active ? 'Disable' : 'Enable' }}</button>
                                </form>
                            </td>
                    </tr>@empty<tr>
                            <td colspan="7">No customers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-5">{{ $customers->links() }}</div>
    </div>
@endsection
