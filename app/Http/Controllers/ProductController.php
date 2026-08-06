<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->with(['category:id,name', 'brand:id,name'])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('products/Index', [
            'products' => $products,
            'filters' => [
                'search' => $request->search,
            ],
        ]);
    }


    public function create()
    {
        return Inertia::render('products/Create', [
            'categories' => Category::where('is_active', true)
                ->orderBy('name')
                ->get(['id', 'name']),
            'brands' => Brand::where('is_active', true)
                ->orderBy('name')
                ->get(['id', 'name']),
        ]);
    }


    public function store(ProductStoreRequest $request)
    {
        Product::create($request->validated());

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully.');
    }


    public function edit(Product $product)
    {
        return Inertia::render('products/Edit', [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(['id', 'name']),
            'brands' => Brand::orderBy('name')->get(['id', 'name']),
        ]);
    }


    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product->update($request->validated());

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully.');
    }


    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
