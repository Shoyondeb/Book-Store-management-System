<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author_id',  // Use author_id instead of author
        'description',
        'price',
        'stock',
        'image',
        'category_id'
    ];

    protected $appends = ['image_url'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // NEW: Add author relationship
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/books/' . $this->image);
        }
        return asset('images/default-book.jpg');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhereHas('author', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            });
        })->when($filters['category'] ?? null, function ($query, $category) {
            $query->where('category_id', $category);
        })->when($filters['author'] ?? null, function ($query, $author) {
            $query->where('author_id', $author);
        })->when($filters['min_price'] ?? null, function ($query, $minPrice) {
            $query->where('price', '>=', $minPrice);
        })->when($filters['max_price'] ?? null, function ($query, $maxPrice) {
            $query->where('price', '<=', $maxPrice);
        });
    }
    // Add this to your Book model
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    public function getRatingCountAttribute()
    {
        return $this->reviews()->count();
    }
}
