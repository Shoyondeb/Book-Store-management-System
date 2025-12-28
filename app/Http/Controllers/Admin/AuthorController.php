<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use Inertia\Inertia;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    public function list(Request $request)
    {
        // Get the per_page value from request, default to 10
        $perPage = $request->input('per_page', 10);

        // Validate it's a positive number
        $perPage = max(1, min(100, (int)$perPage));

        // Get paginated authors
        $authors = Author::withCount('books')->latest()->paginate($perPage)->withQueryString();

        // Get total statistics across ALL authors (not just paginated)
        $totalAuthors = Author::count();
        $totalBooksByAuthors = Author::withCount('books')->get()->sum('books_count');
        $authorsWithBooks = Author::has('books')->count();

        return Inertia::render('Admin/Authors/Index', [
            'authors' => $authors,
            'per_page' => $perPage,
            'total_authors_count' => $totalAuthors,
            'total_books_by_authors' => $totalBooksByAuthors,
            'authors_with_books_count' => $authorsWithBooks,
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
            'name' => 'required|string|max:255|unique:authors',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('authors', 'public');
            $data['image'] = basename($imagePath);
        }

        Author::create($data);

        return redirect()->back()->with('success', 'Author created successfully.');
    }

    public function show(Author $author)
    {
        // Load author with basic info
        $author->load(['books.category', 'books.reviews']);

        // Get books with pagination from query builder, not the loaded relationship
        $books = Book::with(['category', 'author', 'reviews'])
            ->where('author_id', $author->id)
            ->paginate(12);

        // Calculate ratings for each book in the paginated collection
        $books->getCollection()->transform(function ($book) {
            $book->average_rating = $book->reviews->avg('rating') ?? 0;
            $book->rating_count = $book->reviews->count();
            return $book;
        });


        return Inertia::render('Authors/Show', [
            'author' => $author,
            'books' => $books
        ]);
    }

    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:authors,name,' . $author->id,
            'bio' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image
            if ($author->image) {
                Storage::disk('public')->delete('authors/' . $author->image);
            }

            $imagePath = $request->file('image')->store('authors', 'public');
            $data['image'] = basename($imagePath);
        }

        $author->update($data);

        return redirect()->back()->with('success', 'Author updated successfully.');
    }

    public function destroy(Author $author)
    {
        if ($author->books()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete author with associated books.');
        }

        if ($author->image) {
            Storage::disk('public')->delete('authors/' . $author->image);
        }

        $author->delete();
        return redirect()->back()->with('success', 'Author deleted successfully.');
    }
}
