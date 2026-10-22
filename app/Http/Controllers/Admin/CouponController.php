<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CouponController extends Controller
{
    public function index()
    {
        return view('admin.coupons.index', ['coupons' => Coupon::latest()->paginate(15)]);
    }

    public function create()
    {
        return view('admin.coupons.form', ['coupon' => new Coupon]);
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.form', compact('coupon'));
    }

    private function data(Request $request, ?Coupon $coupon = null): array
    {
        $request->merge(['code' => strtoupper(trim((string) $request->input('code', '')))]);
        $data = $request->validate(['code' => ['required', 'string', 'max:50', Rule::unique('coupons', 'code')->ignore($coupon?->id)],
            'type' => ['required', 'in:percent,fixed'], 'value' => ['required', 'numeric', 'gt:0', 'max:999999'],
            'min_order' => ['required', 'numeric', 'min:0'], 'usage_limit' => ['nullable', 'integer', 'min:1'],
            'expires_at' => ['nullable', 'date'], 'is_active' => ['nullable', 'boolean']]);
        if ($data['type'] === 'percent' && $data['value'] > 100) {
            throw ValidationException::withMessages(['value' => 'Percentage cannot exceed 100%.']);
        }
        $data['code'] = strtoupper(trim($data['code']));
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    public function store(Request $request)
    {
        Coupon::create($this->data($request));

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon created.');
    }

    public function update(Request $request, Coupon $coupon)
    {
        $coupon->update($this->data($request, $coupon));

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon updated.');
    }

    public function destroy(Coupon $coupon)
    {
        if ($coupon->used_count) {
            return back()->withErrors(['coupon' => 'Disable an already-used coupon instead of deleting it.']);
        }$coupon->delete();

        return back()->with('success','Coupon deleted.');
    }
}
