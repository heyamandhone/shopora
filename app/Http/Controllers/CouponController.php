<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $coupons = Coupon::query()
            ->when($request->search, function ($query, $search) {
                $query->where('code', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('coupons/Index', [
            'coupons' => $coupons,
            'filters' => ['search' => $request->search],
        ]);
    }

    public function create()
    {
        return Inertia::render('coupons/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:100', 'unique:coupons,code'],
            'type' => ['required', 'in:fixed,percent'],
            'value' => ['required', 'numeric'],
            'minimum_amount' => ['nullable', 'numeric'],
            'expiry_date' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Coupon::create($data);

        return redirect()->route('coupons.index')->with('success', 'Coupon created successfully.');
    }

    public function edit(Coupon $coupon)
    {
        return Inertia::render('coupons/Edit', [
            'coupon' => $coupon,
        ]);
    }

    public function update(Request $request, Coupon $coupon)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:100', 'unique:coupons,code,' . $coupon->id],
            'type' => ['required', 'in:fixed,percent'],
            'value' => ['required', 'numeric'],
            'minimum_amount' => ['nullable', 'numeric'],
            'expiry_date' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $coupon->update($data);

        return redirect()->route('coupons.index')->with('success', 'Coupon updated successfully.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('coupons.index')->with('success', 'Coupon deleted successfully.');
    }
}
