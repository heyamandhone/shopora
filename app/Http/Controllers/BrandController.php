<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandStoreRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $brands = Brand::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();


        return Inertia::render('brands/Index', [
            'brands' => $brands,

            'filters' => [
                'search' => $request->search,
            ],
        ]);
    }


    public function create()
    {
        return Inertia::render('brands/Create');
    }


    public function store(BrandStoreRequest $request)
    {
        Brand::create(
            $request->validated()
        );


        return redirect()
            ->route('brands.index')
            ->with('success', 'Brand created successfully.');
    }


    public function edit(Brand $brand)
    {
        return Inertia::render('brands/Edit', [
            'brand' => $brand,
        ]);
    }


    public function update(
        BrandUpdateRequest $request,
        Brand $brand
    ) {

        $brand->update(
            $request->validated()
        );


        return redirect()
            ->route('brands.index')
            ->with('success', 'Brand updated successfully.');
    }


    public function destroy(Brand $brand)
    {
        $brand->delete();


        return redirect()
            ->route('brands.index')
            ->with('success', 'Brand deleted successfully.');
    }
}
