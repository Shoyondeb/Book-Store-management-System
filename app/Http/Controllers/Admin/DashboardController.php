<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_books' => Book::count(),
            'total_sales' => Order::where('status', 'completed')->sum('total_amount'),
            'total_users' => User::where('role', 'customer')->count(),
            'total_orders' => Order::count(),
            'recent_orders' => Order::with('user')->latest()->take(5)->get(),
        ];

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats
        ]);
    }
}
