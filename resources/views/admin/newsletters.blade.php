@extends('layouts.admin')
@section('title', 'Newsletter Subscribers')
@section('content')
    <h1 class="mb-7 font-serif text-4xl">
        Newsletter Subscribers</h1>
    <div class="panel max-w-3xl overflow-x-auto !p-0">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Subscribed on</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscribers as $s)
                    <tr>
                        <td>{{ $s->email }}</td>
                        <td>{{ $s->created_at->format('M d, Y H:i') }}</td>
                </tr>@empty<tr>
                        <td colspan="2">No subscribers yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-5">{{ $subscribers->links() }}</div>
    <p class="mt-5 text-xs text-stone-500">This stores opt-in addresses; sending campaigns requires a separate email
        marketing service.</p>
@endsection
