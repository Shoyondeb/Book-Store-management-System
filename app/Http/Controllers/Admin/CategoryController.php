<?php
// app/Http\Controllers\Admin\CategoryController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function list(Request $request)  // Rename from index() to list()
    {
        // Get the per_page value from request, default to 10
        $perPage = $request->input('per_page', 10);

        // Validate it's a positive number
        $perPage = max(1, min(100, (int)$perPage));

        // Get paginated categories
        $categories = Category::withCount('books')
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        // Get total statistics across ALL categories (not just paginated)
        $totalCategories = Category::count();
        $activeCategories = Category::has('books')->count();
        $totalBooks = Category::withCount('books')->get()->sum('books_count');

        return Inertia::render('Admin/Categories/Index', [
            'categories' => $categories,
            'per_page' => $perPage,
            'total_categories_count' => $totalCategories,
            'active_categories_count' => $activeCategories,
            'total_books_count' => $totalBooks
        ]);
    }

    // Keep index() for backward compatibility if needed
    public function index()
    {
        return $this->list(request());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories'
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return redirect()->back()->with('success', 'Category created successfully.');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return redirect()->back()->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->books()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete category with associated books.');
        }

        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}
