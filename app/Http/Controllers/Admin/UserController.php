<?php
// app/Http\Controllers\Admin\UserController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function list(Request $request)
    {
        // Get the per_page value from request, default to 10
        $perPage = $request->input('per_page', 10);

        // Validate it's a positive number
        $perPage = max(1, min(100, (int)$perPage));

        $search = $request->input('search', '');

        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->select('id', 'name', 'email', 'role', 'created_at', 'email_verified_at')
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        // Get total counts for all users regardless of pagination
        $totalUsers = User::count();
        $totalAdminCount = User::where('role', 'admin')->count();
        $totalCustomerCount = User::where('role', 'customer')->count();

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
            'totalUsers' => $totalUsers,
            'totalAdminCount' => $totalAdminCount,
            'totalCustomerCount' => $totalCustomerCount,
            'per_page' => $perPage,
            'search' => $search,
            'auth' => [
                'user' => [
                    'email' => auth()->user()->email,
                    'name' => auth()->user()->name,
                ]
            ],
        ]);
    }

    // Keep for backward compatibility
    public function index()
    {
        return $this->list(request());
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,customer'
        ]);

        $user->update(['role' => $request->role]);

        return back()->with('success', 'Role updated successfully');
    }
}
