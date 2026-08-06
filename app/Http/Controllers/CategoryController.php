<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()
            ->with('parent:id,name')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('categories/Index', [
            'categories' => $categories,
            'filters' => [
                'search' => $request->search,
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('categories/Create', [
            'parents' => Category::whereNull('parent_id')
                ->where('is_active', true)
                ->orderBy('name')
                ->get(['id', 'name']),
        ]);
    }

    public function store(CategoryStoreRequest $request)
    {
        Category::create($request->validated());

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return Inertia::render('categories/Edit', [
            'category' => $category,
            'parents' => Category::where('id', '!=', $category->id)
                ->whereNull('parent_id')
                ->orderBy('name')
                ->get(['id', 'name']),
        ]);
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->update($request->validated());

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('success', 'Category deleted successfully.');
    }
}