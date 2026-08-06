<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('customer')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('order_number', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%")
                      ->orWhere('payment_status', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('orders/Index', [
            'orders' => $orders,
            'filters' => ['search' => $request->search],
        ]);
    }

    public function create()
    {
        return Inertia::render('orders/Create', [
            'customers' => Customer::orderBy('first_name')->get(['id', 'first_name', 'last_name']),
        ]);
    }

    public function store(OrderStoreRequest $request)
    {
        Order::create($request->validated());

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function edit(Order $order)
    {
        return Inertia::render('orders/Edit', [
            'order' => $order->load('customer'),
            'customers' => Customer::orderBy('first_name')->get(['id', 'first_name', 'last_name']),
        ]);
    }

    public function update(OrderUpdateRequest $request, Order $order)
    {
        $order->update($request->validated());

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
