<?php
// routes/web.php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StripeController;
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

// Public Shop Routes
Route::get('/shop/home', [ShopController::class, 'home'])->name('shop.home');
Route::get('/shop/books/{book}', [ShopController::class, 'show'])->name('shop.books.show');
// Breeze Auth Routes (includes profile.edit)

// Profile routes in your auth.php (from Breeze)
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


// Cart routes
// Route::middleware(['auth'])->prefix('cart')->name('cart.')->group(function () {
//     Route::get('/', [CartController::class, 'index'])->name('index');
//     Route::post('/add/{book}', [CartController::class, 'add'])->name('add');
//     Route::put('/update/{book}', [CartController::class, 'update'])->name('update');
//     Route::delete('/remove/{book}', [CartController::class, 'remove'])->name('remove');

//     // Checkout routes
//     Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
//     Route::post('/process-checkout', [CartController::class, 'processCheckout'])->name('process-checkout');
//     Route::post('/save-address', [CartController::class, 'saveAddress'])->name('save-address');
// }); 
Route::middleware(['auth', 'verified'])->group(function () {
    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{book}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{book}', [CartController::class, 'remove'])->name('cart.remove');

    // Cart address routes - FIXED METHOD NAMES
    Route::post('/cart/address', [CartController::class, 'saveAddress'])->name('cart.address.save'); // Changed from storeAddress
    Route::put('/cart/address/{address}', [CartController::class, 'updateAddress'])->name('cart.address.update');
    Route::delete('/cart/address/{address}', [CartController::class, 'deleteAddress'])->name('cart.address.delete');
    Route::post('/cart/address/{address}/default', [CartController::class, 'setDefaultAddress'])->name('cart.address.set-default');

    // Checkout route
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

// routes/web.php
Route::middleware(['auth', 'verified'])->group(function () {
    // // Cart routes
    // Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    // Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
    // Route::put('/cart/update/{book}', [CartController::class, 'update'])->name('cart.update');
    // Route::delete('/cart/remove/{book}', [CartController::class, 'remove'])->name('cart.remove');
    // Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // // Address routes (if you don't have them already)
    // Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
    // Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    // Route::put('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    // Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
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

    // Payment Routes
    Route::post('/payment/initiate', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');
    Route::post('/payment/save-order', [PaymentController::class, 'saveOrder'])->name('payment.save-order');
    Route::post('/payment/confirm-stripe', [PaymentController::class, 'confirmStripePayment'])->name('payment.confirm-stripe');
    Route::get('/payment/check-stock', [PaymentController::class, 'checkStock'])->name('payment.check-stock');

    // Payment Success/Cancel Routes
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

    // Payment Page Route
    Route::get('/payment', [PaymentController::class, 'showPaymentPage'])->name('payment.page');

    // Other payment methods (bKash, Nagad, Mobile Banking)
    Route::post('/payment/process-other', [PaymentController::class, 'processOtherPayment'])->name('payment.process.other');
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

// Route::get('/zoom-api-debug', function () {

//     // Get credentials from config
//     $clientId = config('services.zoom.client_id');
//     $clientSecret = config('services.zoom.client_secret');
//     $accountId = config('services.zoom.account_id');

//     // Test 1: Check if credentials are loaded
//     $credsCheck = [
//         'client_id_loaded' => !empty($clientId),
//         'client_secret_loaded' => !empty($clientSecret),
//         'account_id_loaded' => !empty($accountId),
//         'client_id_length' => strlen($clientId),
//         'client_secret_length' => strlen($clientSecret),
//     ];

//     // Test 2: Try to get access token
//     $authToken = null;
//     $tokenError = null;

//     try {
//         $client = new \GuzzleHttp\Client();

//         $response = $client->post('https://zoom.us/oauth/token', [
//             'headers' => [
//                 'Authorization' => 'Basic ' . base64_encode($clientId . ':' . $clientSecret),
//                 'Content-Type' => 'application/x-www-form-urlencoded',
//             ],
//             'form_params' => [
//                 'grant_type' => 'account_credentials',
//                 'account_id' => $accountId,
//             ],
//             'verify' => false, // Disable SSL verify for testing
//         ]);

//         $tokenData = json_decode($response->getBody(), true);
//         $authToken = $tokenData['access_token'] ?? null;
//     } catch (\Exception $e) {
//         $tokenError = $e->getMessage();
//     }

//     // Test 3: Try to create a meeting with the token
//     $meetingCreated = false;
//     $meetingError = null;
//     $meetingResult = null;

//     if ($authToken) {
//         try {
//             $client = new \GuzzleHttp\Client();

//             $meetingData = [
//                 'topic' => 'API Test Meeting',
//                 'type' => 2, // Scheduled meeting
//                 'start_time' => now()->addMinutes(10)->format('Y-m-d\TH:i:s'),
//                 'duration' => 30,
//                 'timezone' => 'UTC',
//                 'password' => substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 8),
//                 'settings' => [
//                     'host_video' => true,
//                     'participant_video' => true,
//                     'join_before_host' => false,
//                     'mute_upon_entry' => false,
//                     'waiting_room' => false,
//                     'audio' => 'both',
//                     'auto_recording' => 'none',
//                 ]
//             ];

//             $response = $client->post('https://api.zoom.us/v2/users/me/meetings', [
//                 'headers' => [
//                     'Authorization' => 'Bearer ' . $authToken,
//                     'Content-Type' => 'application/json',
//                 ],
//                 'json' => $meetingData,
//                 'verify' => false,
//             ]);

//             $meetingResult = json_decode($response->getBody(), true);
//             $meetingCreated = true;
//         } catch (\Exception $e) {
//             $meetingError = $e->getMessage();
//         }
//     }

//     return response()->json([
//         'timestamp' => now()->toDateTimeString(),
//         'server_timezone' => config('app.timezone'),

//         // Credentials Check
//         'credentials' => $credsCheck,
//         'raw_credentials' => [
//             'client_id' => substr($clientId, 0, 10) . '...',
//             'client_secret' => substr($clientSecret, 0, 10) . '...',
//             'account_id' => $accountId,
//         ],

//         // Token Test
//         'token_obtained' => !empty($authToken),
//         'token_length' => strlen($authToken ?? ''),
//         'token_error' => $tokenError,

//         // Meeting Test
//         'meeting_created' => $meetingCreated,
//         'meeting_error' => $meetingError,
//         'meeting_result' => $meetingResult,

//         // Recommendations
//         'next_steps' => [
//             !empty($authToken) ? '✓ Token obtained successfully' : '✗ Fix token acquisition',
//             $meetingCreated ? '✓ Meeting created via API' : '✗ Fix meeting creation',
//         ]
//     ]);
// });

// routes/web.php - Add this test route
// Route::get('/test-real-zoom', function () {
//     $zoomService = new App\Services\ZoomService();

//     $meetingData = [
//         'topic' => 'Real Zoom Test Meeting',
//         'start_time' => now()->addMinutes(10)->format('Y-m-d\TH:i:s\Z'),
//         'duration' => 30,
//         'timezone' => config('app.timezone')
//     ];

//     \Log::info('Testing Zoom API with new credentials', $meetingData);

//     $meeting = $zoomService->createMeeting($meetingData);

//     \Log::info('Zoom API Response', $meeting);

//     if (!$meeting || isset($meeting['provider']) && $meeting['provider'] === 'jitsi') {
//         return response()->json([
//             'status' => 'error',
//             'message' => 'Zoom API is still returning mock or Jitsi meeting',
//             'response' => $meeting,
//             'credentials_check' => [
//                 'client_id' => config('services.zoom.client_id'),
//                 'account_id' => config('services.zoom.account_id'),
//                 'client_secret_set' => !empty(config('services.zoom.client_secret'))
//             ]
//         ]);
//     }

//     return response()->json([
//         'status' => 'success',
//         'message' => 'Real Zoom meeting created!',
//         'meeting' => $meeting,
//         'can_embed' => str_contains($meeting['join_url'] ?? '', 'zoom.us/j/'),
//         'embed_url' => str_replace('/j/', '/wc/join/', $meeting['join_url'] ?? '')
//     ]);
// });


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
