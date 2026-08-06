<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $items = Cart::with('product')
            ->when($request->search, function ($query, $search) {
                $query->where('session_id', 'like', "%{$search}%")
                    ->orWhere('customer_id', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('carts/Index', [
            'items' => $items,
            'filters' => ['search' => $request->search],
        ]);
    }

    public function create()
    {
        return Inertia::render('carts/Create', [
            'products' => Product::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'session_id' => ['required', 'string', 'max:255'],
            'customer_id' => ['nullable', 'exists:customers,id'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric'],
            'options' => ['nullable', 'array'],
        ]);

        Cart::create($data);

        return redirect()->route('carts.index')->with('success', 'Cart item created successfully.');
    }

    public function edit(Cart $cart)
    {
        return Inertia::render('carts/Edit', [
            'item' => $cart->load('product'),
            'products' => Product::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(Request $request, Cart $cart)
    {
        $data = $request->validate([
            'session_id' => ['required', 'string', 'max:255'],
            'customer_id' => ['nullable', 'exists:customers,id'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric'],
            'options' => ['nullable', 'array'],
        ]);

        $cart->update($data);

        return redirect()->route('carts.index')->with('success', 'Cart item updated successfully.');
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();

        return redirect()->route('carts.index')->with('success', 'Cart item deleted successfully.');
    }
}
