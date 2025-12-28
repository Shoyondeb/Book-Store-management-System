<?php

namespace App\Http\Middleware;

use App\Models\Author;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'cart' => fn() => $request->session()->get('cart', []), // FIX THIS LINE
            'authors' => Author::orderBy('name')->get(),
            'cart' => function () use ($request) {
                return $request->session()->get('cart', []);
            },
            'cart' => session()->get('cart', []),
            'cartCount' => count(session()->get('cart', [])),
        ]);
    }
}
