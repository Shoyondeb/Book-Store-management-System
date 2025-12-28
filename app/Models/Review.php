<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'book_id', 'rating', 'comment'];

    protected $casts = [
        'rating' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Check if user can review (bought the book)
    public function canUserReview($userId, $bookId)
    {
        return Order::where('user_id', $userId)
            ->whereHas('orderItems', function ($query) use ($bookId) {
                $query->where('book_id', $bookId);
            })
            ->where('status', 'completed')
            ->exists();
    }
}
