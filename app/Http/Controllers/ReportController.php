<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function index()
    {
        $stats = [
            'orders' => Order::count(),
            'customers' => Customer::count(),
            'products' => Product::count(),
            'revenue' => Order::sum('total'),
        ];

        return Inertia::render('reports/Index', [
            'stats' => $stats,
            'recent_orders' => Order::with('customer')->latest()->take(5)->get(),
        ]);
    }
}
