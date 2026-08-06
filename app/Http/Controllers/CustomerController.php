<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::query()
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('customers/Index', [
            'customers' => $customers,
            'filters' => [ 'search' => $request->search ],
        ]);
    }

    public function create()
    {
        return Inertia::render('customers/Create');
    }

    public function store(CustomerStoreRequest $request)
    {
        Customer::create($request->validated());

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function edit(Customer $customer)
    {
        return Inertia::render('customers/Edit', [ 'customer' => $customer ]);
    }

    public function update(CustomerUpdateRequest $request, Customer $customer)
    {
        $customer->update($request->validated());

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
