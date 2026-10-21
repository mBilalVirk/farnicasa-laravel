@extends('layouts.admin')
@section('title','Store Settings')
@section('content')
<h1 class="mb-7 font-serif text-4xl">Store Settings</h1><form method="POST" action="{{ route('admin.settings.update') }}" class="panel max-w-2xl space-y-5">@csrf @method('PATCH')
@foreach(['store_name'=>'Store name','support_email'=>'Support email','support_phone'=>'Support phone','address'=>'Store address','announcement'=>'Announcement bar'] as $field=>$label)<div><label for="{{ $field }}" class="field-label">{{ $label }}</label><input id="{{ $field }}" class="field" name="{{ $field }}" value="{{ old($field,$values[$field]??'') }}" {{ in_array($field,['store_name','support_email'])?'required':'' }}></div>@endforeach
<div><label for="bank_instructions" class="field-label">Manual bank transfer instructions</label><textarea id="bank_instructions" name="bank_instructions" class="field" rows="5" placeholder="Bank name, account title, IBAN, and payment reference instructions">{{ old('bank_instructions',$values['bank_instructions']??'') }}</textarea><p class="mt-2 text-xs text-muted">Shown only on a bank-transfer order when unpaid. Enter real business bank information before accepting transfer orders.</p></div><button class="btn-dark">Save Store Settings</button></form><p class="mt-5 text-xs text-muted">Currency, shipping threshold, fee, and tax rate are set in .env / config/store.php.</p>
@endsection
