<?php
// app/Http\Controllers\User\CartController.php

namespace App\Http\Controllers\User;

use App\Models\Book;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\Address;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $bookId => $item) {
            $book = Book::with('author')->find($bookId);
            if ($book) {
                $cartItems[] = [
                    'id' => $book->id,
                    'title' => $book->title,
                    'author' => $book->author,
                    'author_name' => $book->author->name ?? 'Unknown Author',
                    'price' => $book->price,
                    'image' => $book->image_url,
                    'quantity' => $item['quantity'],
                    'stock' => $book->stock,
                    'subtotal' => $book->price * $item['quantity']
                ];
                $total += $book->price * $item['quantity'];
            }
        }

        // Get user's addresses
        $addresses = [];
        $defaultAddress = null;
        if (Auth::check()) {
            $addresses = Auth::user()->addresses()->latest()->get();
            $defaultAddress = Auth::user()->addresses()->where('is_default', true)->first();
        }

        return Inertia::render('Shop/Cart', [
            'cartItems' => $cartItems,
            'total' => $total,
            'addresses' => $addresses,
            'defaultAddress' => $defaultAddress
        ]);
    }

    public function add(Request $request, Book $book)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$book->id])) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Book already in cart.',
                    'cartCount' => count($cart)
                ]);
            }
            return redirect()->back()->with('info', 'Book already in cart.');
        }

        if ($book->stock < 1) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Book is out of stock.',
                    'cartCount' => count($cart)
                ]);
            }
            return redirect()->back()->with('error', 'Book is out of stock.');
        }

        $cart[$book->id] = [
            'quantity' => $request->quantity ?? 1
        ];

        session()->put('cart', $cart);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Book added to cart!',
                'cartCount' => count($cart)
            ]);
        }

        return redirect()->back()->with('success', 'Book added to cart!');
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $book->stock
        ]);

        $cart = session()->get('cart', []);

        if ($request->quantity <= 0) {
            unset($cart[$book->id]);
        } else {
            if ($request->quantity > $book->stock) {
                return redirect()->back()->with('error', 'Only ' . $book->stock . ' items available in stock.');
            }

            $cart[$book->id]['quantity'] = $request->quantity;
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Cart updated successfully.');
    }

    public function remove(Book $book)
    {
        $cart = session()->get('cart', []);

        unset($cart[$book->id]);

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Book removed from cart successfully.');
    }

    // New: Save address from cart - RETURN PROPER INERTIA RESPONSE
    public function saveAddress(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line1' => 'required|string|max:500',
            'address_line2' => 'nullable|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'set_as_default' => 'nullable|boolean'
        ]);

        // If set_as_default is true, remove default from all other addresses
        if ($request->set_as_default) {
            Auth::user()->addresses()->update(['is_default' => false]);
        }

        $addressData = $request->only([
            'full_name',
            'phone',
            'address_line1',
            'address_line2',
            'city',
            'state',
            'zip_code',
            'country'
        ]);
        $addressData['is_default'] = $request->set_as_default ?? false;

        $address = Auth::user()->addresses()->create($addressData);

        // Get updated addresses list for response
        $addresses = Auth::user()->addresses()->latest()->get();
        $defaultAddress = Auth::user()->addresses()->where('is_default', true)->first();

        // Return a proper Inertia response that will update the Vue component
        return redirect()->route('cart.index')->with([
            'success' => 'Address saved successfully!',
            'address' => $address, // Send the new address
        ]);
    }

    // New: Update existing address
    public function updateAddress(Request $request, Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line1' => 'required|string|max:500',
            'address_line2' => 'nullable|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'set_as_default' => 'nullable|boolean'
        ]);

        if ($request->set_as_default) {
            Auth::user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $addressData = $request->only([
            'full_name',
            'phone',
            'address_line1',
            'address_line2',
            'city',
            'state',
            'zip_code',
            'country'
        ]);
        $addressData['is_default'] = $request->set_as_default ?? $address->is_default;

        $address->update($addressData);

        // Get updated addresses list
        $addresses = Auth::user()->addresses()->latest()->get();
        $defaultAddress = Auth::user()->addresses()->where('is_default', true)->first();

        return redirect()->route('cart.index')->with('success', 'Address updated successfully!');
    }

    // New: Delete address
    public function deleteAddress(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if address is being used in any order
        if ($address->orders()->exists()) {
            return redirect()->route('cart.index')->with('error', 'Cannot delete address that is associated with orders.');
        }

        $address->delete();

        return redirect()->route('cart.index')->with('success', 'Address deleted successfully!');
    }

    // New: Set default address
    public function setDefaultAddress(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        Auth::user()->addresses()->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return redirect()->route('cart.index')->with('success', 'Default address updated!');
    }

    // Modified: Checkout with address
    // Rename this method from checkout() to processCheckout() 
    public function checkout(Request $request)
    {
        $request->validate([
            'shipping_address_id' => 'required|exists:addresses,id'
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Verify address belongs to user
        $address = Address::where('id', $request->shipping_address_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Calculate total and check stock
        $total = 0;
        $orderItems = [];

        foreach ($cart as $bookId => $item) {
            $book = Book::find($bookId);
            if (!$book || $book->stock < $item['quantity']) {
                return redirect()->route('cart.index')->with('error', "{$book->title} is out of stock or insufficient quantity.");
            }
            $total += $book->price * $item['quantity'];
        }

        // Create order with shipping address
        $order = Order::create([
            'user_id' => auth()->id(),
            'shipping_address_id' => $address->id,
            'total_amount' => $total,
            'status' => 'pending',
            'order_number' => 'ORD' . str_pad(Order::count() + 1, 6, '0', STR_PAD_LEFT)
        ]);

        // Create order items and update stock
        foreach ($cart as $bookId => $item) {
            $book = Book::find($bookId);
            if ($book) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $book->id,
                    'quantity' => $item['quantity'],
                    'price' => $book->price
                ]);

                // Update book stock
                // $book->decrement('stock', $item['quantity']);
            }
        }

        // Clear cart
        // session()->forget('cart');

        return Inertia::render('Shop/Checkout', [
            'order' => $order->load('orderItems.book'),
            'stripeKey' => config('services.stripe.key'),
        ]);
    }
    // Add this method in CartController
    // Add this method too
    public function showCheckout()
    {
        // Check if there's an order in session
        if (session()->has('order_id')) {
            $orderId = session()->get('order_id');
            $order = Order::with('orderItems.book')->find($orderId);

            if ($order) {
                return Inertia::render('Shop/Checkout', [
                    'order' => $order,
                    'stripeKey' => config('services.stripe.key'),
                ]);
            }
        }

        // If no order, redirect to cart
        return redirect()->route('cart.index')->with('error', 'Please proceed from cart to checkout.');
    }
}
