<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerAddressStoreRequest;
use App\Http\Requests\CustomerAddressUpdateRequest;
use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerAddressController extends Controller
{
    public function index(Request $request)
    {
        $addresses = CustomerAddress::with('customer')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('label', 'like', "%{$search}%")
                      ->orWhere('full_name', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('address_line_1', 'like', "%{$search}%")
                      ->orWhere('city', 'like', "%{$search}%")
                      ->orWhere('postal_code', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('customer-addresses/Index', [
            'addresses' => $addresses,
            'filters' => [ 'search' => $request->search ],
        ]);
    }

    public function create()
    {
        return Inertia::render('customer-addresses/Create', [
            'customers' => Customer::orderBy('first_name')->get(['id', 'first_name', 'last_name']),
        ]);
    }

    public function store(CustomerAddressStoreRequest $request)
    {
        CustomerAddress::create($request->validated());

        return redirect()->route('customer-addresses.index')->with('success', 'Address created successfully.');
    }

    public function edit(CustomerAddress $customerAddress)
    {
        return Inertia::render('customer-addresses/Edit', [
            'address' => $customerAddress->load('customer'),
            'customers' => Customer::orderBy('first_name')->get(['id', 'first_name', 'last_name']),
        ]);
    }

    public function update(CustomerAddressUpdateRequest $request, CustomerAddress $customerAddress)
    {
        $customerAddress->update($request->validated());

        return redirect()->route('customer-addresses.index')->with('success', 'Address updated successfully.');
    }

    public function destroy(CustomerAddress $customerAddress)
    {
        $customerAddress->delete();

        return redirect()->route('customer-addresses.index')->with('success', 'Address deleted successfully.');
    }
}
