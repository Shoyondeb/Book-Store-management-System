<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Request $request, Book $book)
    {
        $user = Auth::user();
        $quantity = $request->input('quantity', 1);

        if ($book->stock < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock',
                'cartCount' => $user->cart()->count() ?? 0
            ], 400);
        }

        // Add to cart logic - adjust based on your cart model
        $cartItem = $user->cart()->updateOrCreate(
            ['book_id' => $book->id],
            ['quantity' => \DB::raw('quantity + ' . $quantity)]
        );

        return response()->json([
            'success' => true,
            'message' => 'Added to cart successfully',
            'cartCount' => $user->cart()->count(),
            'item' => [
                'id' => $book->id,
                'title' => $book->title,
                'price' => $book->price,
                'image_url' => $book->image_url
            ]
        ]);
    }
}
