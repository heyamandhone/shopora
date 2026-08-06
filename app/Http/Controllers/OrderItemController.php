<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderItemStoreRequest;
use App\Http\Requests\OrderItemUpdateRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderItemController extends Controller
{
    public function index(Request $request)
    {
        $items = OrderItem::with(['order', 'product'])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('order', function ($q) use ($search) {
                        $q->where('order_number', 'like', "%{$search}%");
                    })
                    ->orWhereHas('product', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('order-items/Index', [
            'items' => $items,
            'filters' => ['search' => $request->search],
        ]);
    }

    public function create()
    {
        return Inertia::render('order-items/Create', [
            'orders' => Order::orderBy('order_number')->get(['id', 'order_number']),
            'products' => Product::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(OrderItemStoreRequest $request)
    {
        OrderItem::create($request->validated());

        return redirect()->route('order-items.index')->with('success', 'Order item created successfully.');
    }

    public function edit(OrderItem $orderItem)
    {
        return Inertia::render('order-items/Edit', [
            'item' => $orderItem->load(['order', 'product']),
            'orders' => Order::orderBy('order_number')->get(['id', 'order_number']),
            'products' => Product::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(OrderItemUpdateRequest $request, OrderItem $orderItem)
    {
        $orderItem->update($request->validated());

        return redirect()->route('order-items.index')->with('success', 'Order item updated successfully.');
    }

    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();

        return redirect()->route('order-items.index')->with('success', 'Order item deleted successfully.');
    }
}
