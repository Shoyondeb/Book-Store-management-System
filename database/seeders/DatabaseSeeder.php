<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@bookstore.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Customer User
        User::create([
            'name' => 'Customer User',
            'email' => 'customer@bookstore.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // Create Categories
        $categories = Category::createMany([
            ['name' => 'Fiction', 'slug' => 'fiction'],
            ['name' => 'Science', 'slug' => 'science'],
            ['name' => 'Technology', 'slug' => 'technology'],
        ]);

        // Create Sample Books
        Book::create([
            'title' => 'The Great Gatsby',
            'author' => 'F. Scott Fitzgerald',
            'description' => 'A classic American novel',
            'price' => 12.99,
            'stock' => 50,
            'category_id' => 1,
        ]);

        Book::create([
            'title' => 'To Kill a Mockingbird',
            'author' => 'Harper Lee',
            'description' => 'A story of racial injustice',
            'price' => 14.99,
            'stock' => 30,
            'category_id' => 1,
        ]);
    }
}
