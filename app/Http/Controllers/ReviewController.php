<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $reviews = Review::with(['customer', 'product'])
            ->when($request->search, function ($query, $search) {
                $query->where('comment', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('reviews/Index', [
            'reviews' => $reviews,
            'filters' => ['search' => $request->search],
        ]);
    }

    public function create()
    {
        return Inertia::render('reviews/Create', [
            'customers' => Customer::orderBy('first_name')->get(['id', 'first_name', 'last_name']),
            'products' => Product::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'product_id' => ['required', 'exists:products,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string'],
            'is_approved' => ['nullable', 'boolean'],
        ]);

        Review::create($data);

        return redirect()->route('reviews.index')->with('success', 'Review created successfully.');
    }

    public function edit(Review $review)
    {
        return Inertia::render('reviews/Edit', [
            'review' => $review->load(['customer', 'product']),
            'customers' => Customer::orderBy('first_name')->get(['id', 'first_name', 'last_name']),
            'products' => Product::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(Request $request, Review $review)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'product_id' => ['required', 'exists:products,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string'],
            'is_approved' => ['nullable', 'boolean'],
        ]);

        $review->update($data);

        return redirect()->route('reviews.index')->with('success', 'Review updated successfully.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('reviews.index')->with('success', 'Review deleted successfully.');
    }
}
