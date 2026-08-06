<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductImageStoreRequest;
use App\Http\Requests\ProductImageUpdateRequest;
use App\Models\ProductImage;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductImageController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductImage::query()->with('product:id,name');

        if ($request->product_id) {
            $query->where('product_id', $request->product_id);
        }

        $images = $query->latest()->paginate(20)->withQueryString();

        return Inertia::render('product-images/Index', [
            'images' => $images,
            'filters' => [
                'product_id' => $request->product_id,
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('product-images/Create', [
            'products' => Product::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(ProductImageStoreRequest $request)
    {
        ProductImage::create($request->validated());

        return redirect()->route('product-images.index')->with('success', 'Image added.');
    }

    public function edit(ProductImage $productImage)
    {
        return Inertia::render('product-images/Edit', [
            'image' => $productImage,
            'products' => Product::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(ProductImageUpdateRequest $request, ProductImage $productImage)
    {
        $productImage->update($request->validated());

        return redirect()->route('product-images.index')->with('success', 'Image updated.');
    }

    public function destroy(ProductImage $productImage)
    {
        $productImage->delete();

        return redirect()->route('product-images.index')->with('success', 'Image deleted.');
    }
}
