<?php
// app/Http\Controllers/Admin/BookController.php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use Inertia\Inertia;
use App\Models\Author;
use App\Models\Review;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function list(Request $request)  // Rename from index() to list()
    {
        // Get the per_page value from request, default to 10
        $perPage = $request->input('per_page', 10);

        // Validate it's a positive number
        $perPage = max(1, min(100, (int)$perPage));

        // Get paginated books
        $books = Book::with(['category', 'author'])
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        // Get total statistics across ALL books (not just paginated)
        $totalBooks = Book::count();
        $totalStock = Book::sum('stock');
        $totalCategories = Category::count();
        $totalAuthors = Author::count();
        $totalValue = Book::sum(DB::raw('price * stock'));
        $averagePrice = Book::avg('price');

        return Inertia::render('Admin/Books/Index', [
            'books' => $books,
            'per_page' => $perPage,
            'categories' => Category::all(),
            'authors' => Author::all(),
            'total_books_count' => $totalBooks,
            'total_stock' => $totalStock,
            'total_categories_count' => $totalCategories,
            'total_authors_count' => $totalAuthors,
            'total_value' => (float) $totalValue,
            'average_price' => (float) $averagePrice,
        ]);
    }

    // Keep index() for backward compatibility
    public function index()
    {
        return $this->list(request());
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books', 'public');
            $data['image'] = basename($imagePath);
        }

        Book::create($data);
        return redirect()->back()->with('success', 'Book created successfully.');
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($book->image) {
                Storage::disk('public')->delete('books/' . $book->image);
            }

            $imagePath = $request->file('image')->store('books', 'public');
            $data['image'] = basename($imagePath);
        }

        $book->update($data);
        return redirect()->back()->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }

        $book->delete();
        return redirect()->back()->with('success', 'Book deleted successfully.');
    }
}
