@extends('layouts.admin')
@section('title','Customer Messages')
@section('content')
<h1 class="mb-7 font-serif text-4xl">Contact Messages</h1><div class="space-y-4">@forelse($contacts as $m)<div class="panel"><div class="flex flex-wrap justify-between gap-3"><div><h2 class="font-semibold">{{ $m->subject }} @unless($m->is_read)<span class="ml-2 rounded bg-amber-100 px-2 py-1 text-xs text-amber-800">NEW</span>@endunless</h2><p class="mt-1 text-xs text-muted">{{ $m->name }} · {{ $m->email }} · {{ $m->created_at->format('M d, Y H:i') }}</p></div>@unless($m->is_read)<form method="POST" action="{{ route('admin.contacts.read',$m) }}">@csrf @method('PATCH')<button class="text-sm text-olive underline">Mark Read</button></form>@endunless</div><p class="mt-4 whitespace-pre-wrap text-sm leading-7 text-stone-700">{{ $m->message }}</p></div>@empty<div class="panel text-sm">No messages have been received yet.</div>@endforelse</div><div class="mt-5">{{ $contacts->links() }}</div>
@endsection
