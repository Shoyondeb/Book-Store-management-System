<?php
// routes/web.php

use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\ShopController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\ZoomMeetingController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\OrderHistoryController;

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect('/admin/dashboard');
        }
        return redirect('/shop/home');
    }
    return redirect('/login');
});

//From footer
Route::get('/about', function () {
    return Inertia::render('Footer/About');
})->name('about');

Route::get('/contact', function () {
    return Inertia::render('Footer/Contact');
})->name('contact');

Route::get('/privacy', function () {
    return Inertia::render('Footer/Privacy');
})->name('privacy');

Route::get('/terms', function () {
    return Inertia::render('Footer/Terms');
})->name('terms');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');
//End

// Public Shop Routes
Route::get('/shop/home', [ShopController::class, 'home'])->name('shop.home');
Route::get('/shop/books/{book}', [ShopController::class, 'show'])->name('shop.books.show');
// Breeze Auth Routes (includes profile.edit)

// Profile routes in your auth.php (from Breeze)
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::middleware(['auth', 'verified'])->group(function () {
    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{book}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{book}', [CartController::class, 'remove'])->name('cart.remove');

    // Cart address routes
    Route::post('/cart/address', [CartController::class, 'saveAddress'])->name('cart.address.save');
    Route::put('/cart/address/{address}', [CartController::class, 'updateAddress'])->name('cart.address.update');
    Route::delete('/cart/address/{address}', [CartController::class, 'deleteAddress'])->name('cart.address.delete');
    Route::post('/cart/address/{address}/default', [CartController::class, 'setDefaultAddress'])->name('cart.address.set-default');

    // Checkout routes - BOTH
    Route::get('/cart/checkout', [CartController::class, 'showCheckout'])->name('cart.checkout'); // GET
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout.post'); // POST
});

// Authenticated User Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{book}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{book}', [CartController::class, 'remove'])->name('cart.remove');
    // Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // Stripe Payment Routes
    Route::post('/stripe/create-payment-intent', [StripeController::class, 'createPaymentIntent'])->name('stripe.create-payment-intent');
    Route::post('/stripe/update-order', [StripeController::class, 'updateOrder'])->name('stripe.update-order');
    Route::post('/payment/create-intent', [PaymentController::class, 'createPaymentIntent'])->name('payment.create.intent');
    Route::post('/payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');

    // Success Pages
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');


    // Payment Routes
    Route::post('/payment/initiate', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');
    Route::post('/payment/save-order', [PaymentController::class, 'saveOrder'])->name('payment.save-order');
    Route::post('/payment/confirm-stripe', [PaymentController::class, 'confirmStripePayment'])->name('payment.confirm-stripe');
    Route::get('/payment/check-stock', [PaymentController::class, 'checkStock'])->name('payment.check-stock');

    // Payment Success/Cancel Routes
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/success/order', [PaymentController::class, 'orderSuccess'])->name('payment.order');

    Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

    // Payment Page Route
    Route::get('/payment', [PaymentController::class, 'showPaymentPage'])->name('payment.page');

    // Other payment methods (bKash, Nagad, Mobile Banking)
    Route::post('/payment/process-other', [PaymentController::class, 'processOtherPayment'])->name('payment.process.other');
    Route::post('/payment/cod', [PaymentController::class, 'processCOD'])->name('payment.cod');
});
Route::middleware(['auth'])->group(function () {
    Route::post('/cart/ajax-add/{book}', [CartController::class, 'ajaxAdd'])->name('cart.ajax.add');
});

// Admin Routesa
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Books Management
    Route::get('/books', [BookController::class, 'index'])->name('admin.books.index');
    Route::post('/books', [BookController::class, 'store'])->name('admin.books.store');
    Route::put('/books/{book}', [BookController::class, 'update'])->name('admin.books.update');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('admin.books.destroy');

    // Categories Management
    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
    Route::get('/categories', [CategoryController::class, 'list'])->name('admin.categories.index');

    // Orders Management
    Route::get('/orders', [OrderController::class, 'list'])->name('admin.orders.index');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status');
    Route::put('/orders/{order}/verify-payment', [OrderController::class, 'verifyPayment'])
        ->name('admin.orders.verify-payment');

    //Users Management
    // Route::get('/users', [UserController::class, 'list'])->name("admin.users.list");
    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name("admin.users.updateRole");
    Route::get('/admin/users', [UserController::class, 'list'])->name('admin.users.list');

    // Authors Management
    Route::get('/authors', [AuthorController::class, 'index'])->name('admin.authors.index');

    Route::get('/admin/authors', [AuthorController::class, 'list'])->name('admin.authors.list');
    Route::post('/admin/authors', [AuthorController::class, 'store'])->name('admin.authors.store');
    Route::put('/admin/authors/{author}', [AuthorController::class, 'update'])->name('admin.authors.update');
    Route::delete('/admin/authors/{author}', [AuthorController::class, 'destroy'])->name('admin.authors.destroy');
    Route::get('/authors/{author}', [AuthorController::class, 'show'])->name('authors.show');
});

// Order History Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/orders/history', [OrderHistoryController::class, 'index'])->name('orders.history');
    Route::get('/orders/{order}', [OrderHistoryController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/invoice', [OrderHistoryController::class, 'invoice'])->name('orders.invoice');
    Route::get('/orders/history', [OrderHistoryController::class, 'list'])->name('orders.history');
    Route::get('/orders/{order}', [OrderHistoryController::class, 'show'])->name('orders.show');
});

// Add to routes/web.php temporarily
Route::get('/test-email', function () {
    $order = \App\Models\Order::with(['user', 'orderItems.book.author'])->first();

    if (!$order) {
        return "No orders found. Please create an order first.";
    }

    \Illuminate\Support\Facades\Mail::to('test@example.com')->send(new \App\Mail\OrderConfirmation($order));
    return "Test email sent! Check your email inbox.";
});

// Review Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/books/{book}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::get('/books/{book}/reviews', [ReviewController::class, 'index'])->name('reviews.index');
});

Route::middleware(['auth'])->group(
    function () {
        // Webhook Routes (for Stripe/SLLCommerz)
        Route::post('/webhook/stripe', [StripeController::class, 'handleWebhook'])->name('webhook.stripe');
        Route::post('/webhook/sslcommerz', [PaymentController::class, 'handleSSLCommerzWebhook'])->name('webhook.sslcommerz');
    }
);

Route::get('/test-email', function () {
    $order = App\Models\Order::with(['user', 'orderItems.book'])->first();
    $user = $order->user;

    if ($order && $user) {
        Mail::to($user->email)->send(new App\Mail\PaymentSuccessMail($order, $user));
        return 'Test email sent to ' . $user->email;
    }

    return 'No order found for testing';
});

//Route for bkash
Route::middleware(['auth'])->group(function () {
    // Payment Routes for bKash
    Route::get('/bkash/payment', [App\Http\Controllers\BkashTokenizePaymentController::class, 'index']);
    Route::get('/bkash/create-payment', [App\Http\Controllers\BkashTokenizePaymentController::class, 'createPayment'])->name('bkash-create-payment');
    Route::get('/bkash/callback', [App\Http\Controllers\BkashTokenizePaymentController::class, 'callBack'])->name('bkash-callBack');


    //additional will go with admin middleware
    //search payment
    Route::get('/bkash/search/{trxID}', [App\Http\Controllers\BkashTokenizePaymentController::class, 'searchTnx'])->name('bkash-serach');

    //refund payment routes
    Route::get('/bkash/refund', [App\Http\Controllers\BkashTokenizePaymentController::class, 'refund'])->name('bkash-refund');
    Route::get('/bkash/refund/status', [App\Http\Controllers\BkashTokenizePaymentController::class, 'refundStatus'])->name('bkash-refund-status');
});


// Zoom Meetings Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('meetings')->name('meetings.')->group(function () {
        Route::get('/', [ZoomMeetingController::class, 'index'])->name('index');
        Route::get('/create', [ZoomMeetingController::class, 'create'])->name('create');
        Route::post('/', [ZoomMeetingController::class, 'store'])->name('store'); // ✅ FIXED
        Route::get('/{meeting}', [ZoomMeetingController::class, 'show'])->name('show');
        Route::get('/{meeting}/join', [ZoomMeetingController::class, 'join'])->name('join');
        Route::delete('/{meeting}', [ZoomMeetingController::class, 'destroy'])->name('destroy');
    });
});



// Temporary dashboard route for Breeze redirects
Route::get('/dashboard', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'admin') {
            return redirect('/admin/dashboard');
        }
        return redirect('/shop/home');
    }
    return redirect('/login');
})->middleware('auth')->name('dashboard');

require __DIR__ . '/auth.php';

// routes/web.php

// use Inertia\Inertia;
// use Illuminate\Support\Facades\Mail;
// use Illuminate\Support\Facades\Route;
// use Illuminate\Foundation\Application;
// use App\Http\Controllers\ReviewController;
// use App\Http\Controllers\StripeController;
// use App\Http\Controllers\ContactController;
// use App\Http\Controllers\MeetingController;
// use App\Http\Controllers\PaymentController;
// use App\Http\Controllers\ProfileController;
// use App\Http\Controllers\User\CartController;
// use App\Http\Controllers\User\ShopController;
// use App\Http\Controllers\Admin\BookController;
// use App\Http\Controllers\Admin\UserController;
// use App\Http\Controllers\Admin\OrderController;
// use App\Http\Controllers\ZoomMeetingController;
// use App\Http\Controllers\Admin\AuthorController;
// use App\Http\Controllers\Admin\CategoryController;
// use App\Http\Controllers\Admin\DashboardController;
// use App\Http\Controllers\User\OrderHistoryController;

// Route::get('/', function () {
//     if (auth()->check()) {
//         if (auth()->user()->isAdmin()) {
//             return redirect('/admin/dashboard');
//         }
//         return redirect('/shop/home');
//     }
//     return redirect('/login');
// });

// //From footer
// Route::get('/about', function () {
//     return Inertia::render('Footer/About');
// })->name('about');

// Route::get('/contact', function () {
//     return Inertia::render('Footer/Contact');
// })->name('contact');

// Route::get('/privacy', function () {
//     return Inertia::render('Footer/Privacy');
// })->name('privacy');

// Route::get('/terms', function () {
//     return Inertia::render('Footer/Terms');
// })->name('terms');
// Route::get('/contact', [ContactController::class, 'show'])->name('contact');
// Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');
// //End

// // Public Shop Routes
// Route::get('/shop/home', [ShopController::class, 'home'])->name('shop.home');
// Route::get('/shop/books/{book}', [ShopController::class, 'show'])->name('shop.books.show');
// // Breeze Auth Routes (includes profile.edit)

// // Profile routes in your auth.php (from Breeze)
// Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
// Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
// Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// Route::middleware(['auth', 'verified'])->group(function () {
//     // Cart routes
//     Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
//     Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
//     Route::put('/cart/update/{book}', [CartController::class, 'update'])->name('cart.update');
//     Route::delete('/cart/remove/{book}', [CartController::class, 'remove'])->name('cart.remove');

//     // Cart address routes
//     Route::post('/cart/address', [CartController::class, 'saveAddress'])->name('cart.address.save');
//     Route::put('/cart/address/{address}', [CartController::class, 'updateAddress'])->name('cart.address.update');
//     Route::delete('/cart/address/{address}', [CartController::class, 'deleteAddress'])->name('cart.address.delete');
//     Route::post('/cart/address/{address}/default', [CartController::class, 'setDefaultAddress'])->name('cart.address.set-default');

//     // Checkout routes - BOTH
//     Route::get('/cart/checkout', [CartController::class, 'showCheckout'])->name('cart.checkout'); // GET
//     Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout.post'); // POST
// });

// // Authenticated User Routes
// Route::middleware(['auth', 'verified'])->group(function () {
//     // Cart Routes
//     Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
//     Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
//     Route::put('/cart/update/{book}', [CartController::class, 'update'])->name('cart.update');
//     Route::delete('/cart/remove/{book}', [CartController::class, 'remove'])->name('cart.remove');
//     // Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

//     // Stripe Payment Routes
//     Route::post('/stripe/create-payment-intent', [StripeController::class, 'createPaymentIntent'])->name('stripe.create-payment-intent');
//     Route::post('/stripe/update-order', [StripeController::class, 'updateOrder'])->name('stripe.update-order');

//     // Payment Routes
//     Route::post('/payment/initiate', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');
//     Route::post('/payment/save-order', [PaymentController::class, 'saveOrder'])->name('payment.save-order');
//     Route::post('/payment/confirm-stripe', [PaymentController::class, 'confirmStripePayment'])->name('payment.confirm-stripe');
//     Route::get('/payment/check-stock', [PaymentController::class, 'checkStock'])->name('payment.check-stock');

//     // Payment Success/Cancel Routes
//     Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
//     Route::get('/payment/success/order', [PaymentController::class, 'orderSuccess'])->name('payment.order');

//     Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

//     // Payment Page Route
//     Route::get('/payment', [PaymentController::class, 'showPaymentPage'])->name('payment.page');

//     // Other payment methods (bKash, Nagad, Mobile Banking)
//     Route::post('/payment/process-other', [PaymentController::class, 'processOtherPayment'])->name('payment.process.other');
//     Route::post('/payment/cod', [PaymentController::class, 'processCOD'])->name('payment.cod');
// });
// Route::middleware(['auth'])->group(function () {
//     Route::post('/cart/ajax-add/{book}', [CartController::class, 'ajaxAdd'])->name('cart.ajax.add');
// });

// // Admin Routesa
// Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

//     // Books Management
//     Route::get('/books', [BookController::class, 'index'])->name('admin.books.index');
//     Route::post('/books', [BookController::class, 'store'])->name('admin.books.store');
//     Route::put('/books/{book}', [BookController::class, 'update'])->name('admin.books.update');
//     Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('admin.books.destroy');

//     // Categories Management
//     Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
//     Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
//     Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
//     Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
//     Route::get('/categories', [CategoryController::class, 'list'])->name('admin.categories.index');

//     // Orders Management
//     Route::get('/orders', [OrderController::class, 'list'])->name('admin.orders.index');
//     Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status');
//     Route::put('/orders/{order}/verify-payment', [OrderController::class, 'verifyPayment'])
//         ->name('admin.orders.verify-payment');

//     //Users Management
//     // Route::get('/users', [UserController::class, 'list'])->name("admin.users.list");
//     Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name("admin.users.updateRole");
//     Route::get('/admin/users', [UserController::class, 'list'])->name('admin.users.list');

//     // Authors Management
//     Route::get('/authors', [AuthorController::class, 'index'])->name('admin.authors.index');

//     Route::get('/admin/authors', [AuthorController::class, 'list'])->name('admin.authors.list');
//     Route::post('/admin/authors', [AuthorController::class, 'store'])->name('admin.authors.store');
//     Route::put('/admin/authors/{author}', [AuthorController::class, 'update'])->name('admin.authors.update');
//     Route::delete('/admin/authors/{author}', [AuthorController::class, 'destroy'])->name('admin.authors.destroy');
//     Route::get('/authors/{author}', [AuthorController::class, 'show'])->name('authors.show');
// });

// // Order History Routes
// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::get('/orders/history', [OrderHistoryController::class, 'index'])->name('orders.history');
//     Route::get('/orders/{order}', [OrderHistoryController::class, 'show'])->name('orders.show');
//     Route::get('/orders/{order}/invoice', [OrderHistoryController::class, 'invoice'])->name('orders.invoice');
//     Route::get('/orders/history', [OrderHistoryController::class, 'list'])->name('orders.history');
//     Route::get('/orders/{order}', [OrderHistoryController::class, 'show'])->name('orders.show');
// });

// // Add to routes/web.php temporarily
// Route::get('/test-email', function () {
//     $order = \App\Models\Order::with(['user', 'orderItems.book.author'])->first();

//     if (!$order) {
//         return "No orders found. Please create an order first.";
//     }

//     \Illuminate\Support\Facades\Mail::to('test@example.com')->send(new \App\Mail\OrderConfirmation($order));
//     return "Test email sent! Check your email inbox.";
// });

// // Review Routes
// Route::middleware(['auth'])->group(function () {
//     Route::post('/books/{book}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
//     Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
//     Route::get('/books/{book}/reviews', [ReviewController::class, 'index'])->name('reviews.index');
// });

// Route::middleware(['auth'])->group(
//     function () {
//         // Webhook Routes (for Stripe/SLLCommerz)
//         Route::post('/webhook/stripe', [StripeController::class, 'handleWebhook'])->name('webhook.stripe');
//         Route::post('/webhook/sslcommerz', [PaymentController::class, 'handleSSLCommerzWebhook'])->name('webhook.sslcommerz');
//     }
// );

// Route::get('/test-email', function () {
//     $order = App\Models\Order::with(['user', 'orderItems.book'])->first();
//     $user = $order->user;

//     if ($order && $user) {
//         Mail::to($user->email)->send(new App\Mail\PaymentSuccessMail($order, $user));
//         return 'Test email sent to ' . $user->email;
//     }

//     return 'No order found for testing';
// });

// //Route for bkash
// Route::middleware(['auth'])->group(function () {
//     // Payment Routes for bKash
//     Route::get('/bkash/payment', [App\Http\Controllers\BkashTokenizePaymentController::class, 'index']);
//     Route::get('/bkash/create-payment', [App\Http\Controllers\BkashTokenizePaymentController::class, 'createPayment'])->name('bkash-create-payment');
//     Route::get('/bkash/callback', [App\Http\Controllers\BkashTokenizePaymentController::class, 'callBack'])->name('bkash-callBack');


//     //additional will go with admin middleware
//     //search payment
//     Route::get('/bkash/search/{trxID}', [App\Http\Controllers\BkashTokenizePaymentController::class, 'searchTnx'])->name('bkash-serach');

//     //refund payment routes
//     Route::get('/bkash/refund', [App\Http\Controllers\BkashTokenizePaymentController::class, 'refund'])->name('bkash-refund');
//     Route::get('/bkash/refund/status', [App\Http\Controllers\BkashTokenizePaymentController::class, 'refundStatus'])->name('bkash-refund-status');
// });


// // Zoom Meetings Routes
// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::prefix('meetings')->name('meetings.')->group(function () {
//         Route::get('/', [ZoomMeetingController::class, 'index'])->name('index');
//         Route::get('/create', [ZoomMeetingController::class, 'create'])->name('create');
//         Route::post('/', [ZoomMeetingController::class, 'store'])->name('store'); // ✅ FIXED
//         Route::get('/{meeting}', [ZoomMeetingController::class, 'show'])->name('show');
//         Route::get('/{meeting}/join', [ZoomMeetingController::class, 'join'])->name('join');
//         Route::delete('/{meeting}', [ZoomMeetingController::class, 'destroy'])->name('destroy');
//     });
// });



// // Temporary dashboard route for Breeze redirects
// Route::get('/dashboard', function () {
//     if (auth()->check()) {
//         if (auth()->user()->role === 'admin') {
//             return redirect('/admin/dashboard');
//         }
//         return redirect('/shop/home');
//     }
//     return redirect('/login');
// })->middleware('auth')->name('dashboard'); 
