<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Author extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'bio', 'image'];

    protected $appends = ['image_url'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/authors/' . $this->image);
        }
        return asset('images/default-author.jpg');
    }

    // Auto-generate slug from name
    public static function boot()
    {
        parent::boot();

        static::creating(function ($author) {
            $author->slug = \Illuminate\Support\Str::slug($author->name);
        });

        static::updating(function ($author) {
            $author->slug = \Illuminate\Support\Str::slug($author->name);
        });
    }
}
