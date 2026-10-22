@extends('layouts.admin')
@section('title', $coupon->exists ? 'Edit Coupon' : 'New Coupon')
@section('content')
    <a href="{{ route('admin.coupons.index') }}" class="text-sm text-olive">
        ← Back to Coupons</a>
    <h1 class="my-6 font-serif text-4xl">{{ $coupon->exists ? 'Edit Coupon' : 'Create Coupon' }}</h1>
    <form method="POST"
        action="{{ $coupon->exists ? route('admin.coupons.update', $coupon) : route('admin.coupons.store') }}"
        class="panel max-w-2xl space-y-5">@csrf @if ($coupon->exists)
            @method('PUT')
        @endif
        <div class="grid gap-5 sm:grid-cols-2">
            <div><label class="field-label" for="code">Code *</label><input id="code" name="code"
                    class="field uppercase" value="{{ old('code', $coupon->code) }}" required></div>
            <div><label class="field-label" for="type">Discount type</label><select id="type" name="type"
                    class="field">
                    <option value="percent" {{ old('type', $coupon->type) === 'percent' ? 'selected' : '' }}>Percentage (%)
                    </option>
                    <option value="fixed" {{ old('type', $coupon->type) === 'fixed' ? 'selected' : '' }}>Fixed ($)</option>
                </select></div>
            <div><label class="field-label" for="value">Value *</label><input class="field" id="value"
                    type="number" step="0.01" min="0.01" name="value" value="{{ old('value', $coupon->value) }}"
                    required></div>
            <div><label class="field-label" for="min_order">Minimum Order ($)</label><input class="field" id="min_order"
                    type="number" step="0.01" min="0" name="min_order"
                    value="{{ old('min_order', $coupon->min_order ?? 0) }}" required></div>
            <div><label class="field-label" for="usage_limit">Redemption limit (blank=unlimited)</label><input
                    class="field" id="usage_limit" type="number" min="1" name="usage_limit"
                    value="{{ old('usage_limit', $coupon->usage_limit) }}"></div>
            <div><label class="field-label" for="expires_at">Expiration</label><input class="field" id="expires_at"
                    type="datetime-local" name="expires_at"
                    value="{{ old('expires_at', $coupon->expires_at?->format('Y-m-d\TH:i')) }}"></div>
        </div><label class="flex gap-2 text-sm"><input type="checkbox" name="is_active" value="1"
                class="rounded text-olive"
                {{ old('is_active', $coupon->exists ? $coupon->is_active : true) ? 'checked' : '' }}>
            Coupon Active</label><button class="btn-dark">Save Coupon</button>
    </form>
@endsection
