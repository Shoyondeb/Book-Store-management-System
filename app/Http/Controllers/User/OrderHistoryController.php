<?php
// app/Http/Controllers\User\OrderHistoryController.php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderHistoryController extends Controller
{
    public function list(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $perPage = max(1, min(100, (int)$perPage));

        // ADD shippingAddress to the with() method
        $orders = Order::with(['user', 'orderItems.book.author', 'shippingAddress'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return Inertia::render('Orders/History', [
            'orders' => $orders,
            'per_page' => $perPage
        ]);
    }

    public function index()
    {
        return $this->list(request());
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        // ADD shippingAddress to the load() method
        $order->load(['orderItems.book', 'user', 'shippingAddress']);

        return Inertia::render('Orders/Show', [
            'order' => $order
        ]);
    }
}
