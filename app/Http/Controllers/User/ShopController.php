<?php
// app/Http/Controllers/User/ShopController.php

namespace App\Http\Controllers\User;

use App\Models\Book;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\Review;
use App\Models\Category;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function home(Request $request)
    {
        $books = Book::with(['category', 'author', 'reviews'])
            ->filter($request->only(['search', 'category', 'author', 'min_price', 'max_price']))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        // Calculate average rating and count for each book
        $books->getCollection()->transform(function ($book) {
            $book->average_rating = $book->reviews->avg('rating') ?? 0;
            $book->rating_count = $book->reviews->count();
            return $book;
        });

        return Inertia::render('Shop/Home', [
            'books' => $books,
            'categories' => Category::all(),
            'authors' => Author::all(), // Add authors to the response
            'filters' => $request->only(['search', 'category', 'author', 'min_price', 'max_price'])
        ]);
    }

    public function show(Book $book)
    {
        $book->load(['category', 'author', 'reviews.user']);

        // Calculate average rating and count for main book
        $book->average_rating = $book->reviews->avg('rating') ?? 0;
        $book->rating_count = $book->reviews->count();

        // Check if user can review (purchased the book)
        $canReview = false;
        if (auth()->check()) {
            $hasPurchased = Order::where('user_id', auth()->id())
                ->whereHas('orderItems', function ($query) use ($book) {
                    $query->where('book_id', $book->id);
                })
                ->where('status', 'completed')
                ->exists();

            $alreadyReviewed = Review::where('user_id', auth()->id())
                ->where('book_id', $book->id)
                ->exists();

            $canReview = $hasPurchased;
        }

        // Get related books with reviews and calculate ratings
        $relatedBooks = Book::with(['category', 'author', 'reviews'])
            ->where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->limit(4)
            ->get()
            ->map(function ($relatedBook) {
                $relatedBook->average_rating = $relatedBook->reviews->avg('rating') ?? 0;
                $relatedBook->rating_count = $relatedBook->reviews->count();
                return $relatedBook;
            });

        return Inertia::render('Shop/BookDetails', [
            'book' => $book,
            'canReview' => $canReview,
            'relatedBooks' => $relatedBooks
        ]);
    }
}
