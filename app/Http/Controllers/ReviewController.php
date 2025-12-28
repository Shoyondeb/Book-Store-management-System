<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReviewController extends Controller
{
    public function store(Request $request, Book $book)
    {
        $hasPurchased = Order::where('user_id', auth()->id())
            ->whereHas('orderItems', function ($query) use ($book) {
                $query->where('book_id', $book->id);
            })
            ->where('status', 'completed')
            ->exists();

        if (!$hasPurchased) {
            return redirect()->back()->with('error', 'You need to purchase this book before reviewing.');
        }

        // Check if user already reviewed - UPDATE instead of block
        $existingReview = Review::where('user_id', auth()->id())
            ->where('book_id', $book->id)
            ->first();

        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000'
        ]);

        if ($existingReview) {
            // Update existing review
            $existingReview->update([
                'rating' => $request->rating,
                'comment' => $request->comment
            ]);

            return redirect()->back()->with('success', 'Review updated successfully!');
        }

        // Create new review
        Review::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }
    public function destroy(Review $review)
    {
        // Only admin or review owner can delete
        if (auth()->user()->role !== 'admin' && auth()->id() !== $review->user_id) {
            abort(403);
        }
        $review->delete();
        return redirect()->back()->with('success', 'Review deleted successfully.');
    }
}
