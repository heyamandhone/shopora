<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::with('order')
            ->when($request->search, function ($query, $search) {
                $query->where('transaction_id', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('payments/Index', [
            'payments' => $payments,
            'filters' => ['search' => $request->search],
        ]);
    }

    public function create()
    {
        return Inertia::render('payments/Create', [
            'orders' => Order::orderBy('order_number')->get(['id', 'order_number']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => ['required', 'exists:orders,id'],
            'payment_method' => ['required', 'string', 'max:100'],
            'transaction_id' => ['nullable', 'string', 'max:255'],
            'amount' => ['required', 'numeric'],
            'status' => ['required', 'in:pending,paid,failed,refunded'],
            'notes' => ['nullable', 'string'],
        ]);

        Payment::create($data);

        return redirect()->route('payments.index')->with('success', 'Payment created successfully.');
    }

    public function edit(Payment $payment)
    {
        return Inertia::render('payments/Edit', [
            'payment' => $payment->load('order'),
            'orders' => Order::orderBy('order_number')->get(['id', 'order_number']),
        ]);
    }

    public function update(Request $request, Payment $payment)
    {
        $data = $request->validate([
            'order_id' => ['required', 'exists:orders,id'],
            'payment_method' => ['required', 'string', 'max:100'],
            'transaction_id' => ['nullable', 'string', 'max:255'],
            'amount' => ['required', 'numeric'],
            'status' => ['required', 'in:pending,paid,failed,refunded'],
            'notes' => ['nullable', 'string'],
        ]);

        $payment->update($data);

        return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
    }
}
