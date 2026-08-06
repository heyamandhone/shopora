<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $items = Wishlist::with(['customer', 'product'])
            ->when($request->search, function ($query, $search) {
                $query->whereHas('product', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('wishlists/Index', [
            'items' => $items,
            'filters' => ['search' => $request->search],
        ]);
    }

    public function create()
    {
        return Inertia::render('wishlists/Create', [
            'customers' => Customer::orderBy('first_name')->get(['id', 'first_name', 'last_name']),
            'products' => Product::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'product_id' => ['required', 'exists:products,id'],
            'notes' => ['nullable', 'string'],
        ]);

        Wishlist::create($data);

        return redirect()->route('wishlists.index')->with('success', 'Wishlist item created successfully.');
    }

    public function edit(Wishlist $wishlist)
    {
        return Inertia::render('wishlists/Edit', [
            'item' => $wishlist->load(['customer', 'product']),
            'customers' => Customer::orderBy('first_name')->get(['id', 'first_name', 'last_name']),
            'products' => Product::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(Request $request, Wishlist $wishlist)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'product_id' => ['required', 'exists:products,id'],
            'notes' => ['nullable', 'string'],
        ]);

        $wishlist->update($data);

        return redirect()->route('wishlists.index')->with('success', 'Wishlist item updated successfully.');
    }

    public function destroy(Wishlist $wishlist)
    {
        $wishlist->delete();

        return redirect()->route('wishlists.index')->with('success', 'Wishlist item deleted successfully.');
    }
}
