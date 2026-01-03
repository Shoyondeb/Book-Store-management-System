<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\Book;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\OrderItem;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;
use App\Mail\PaymentSuccessMail;
use App\Mail\CODConfirmationMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\Exception\ApiErrorException;

class PaymentController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    // Show Payment Page
    public function showPaymentPage()
    {
        return Inertia::render('Payment');
    }

    // Create Stripe Payment Intent
    public function createPaymentIntent(Request $request)
    {
        try {
            $request->validate([
                'order_id' => 'required|exists:orders,id',
                'amount' => 'required|numeric|min:1',
            ]);

            $order = Order::with('orderItems.book')->findOrFail($request->order_id);

            // Check stock availability
            foreach ($order->orderItems as $item) {
                if ($item->book->stock < $item->quantity) {
                    return response()->json([
                        'error' => "Insufficient stock for {$item->book->title}. Available: {$item->book->stock}, Requested: {$item->quantity}"
                    ], 400);
                }
            }

            $amount = $order->total_amount * 100;

            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'bdt',
                'payment_method_types' => ['card'],
                'metadata' => [
                    'order_id' => $order->id,
                    'user_id' => auth()->id(),
                ]
            ]);

            session(['stripe_order_' . $paymentIntent->id => $order->id]);
        } catch (ApiErrorException $e) {
            Log::error('Stripe API Error: ' . $e->getMessage());
            return response()->json(['error' => 'Stripe payment error'], 500);
        } catch (\Exception $e) {
            Log::error('Payment Intent Error: ' . $e->getMessage());
            return response()->json(['error' => 'Error creating payment'], 500);
        }
    }

    // Process Stripe Payment
    public function processPayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_intent_id' => 'required|string',
        ]);

        // DEBUG: Start
        Log::info('🔄 Stripe processPayment called', [
            'order_id' => $request->order_id,
            'payment_intent_id' => $request->payment_intent_id,
            'user_id' => auth()->id()
        ]);

        return DB::transaction(function () use ($request) {
            try {
                $paymentIntent = PaymentIntent::retrieve($request->payment_intent_id);

                if ($paymentIntent->status !== 'succeeded') {
                    Log::error('❌ Stripe payment not succeeded', [
                        'payment_intent_id' => $request->payment_intent_id,
                        'status' => $paymentIntent->status,
                        'order_id' => $request->order_id
                    ]);

                    return response()->json([
                        'error' => 'Payment not completed. Status: ' . $paymentIntent->status
                    ], 400);
                }

                // DEBUG: Before loading order
                Log::info('📦 Loading order with relationships', [
                    'order_id' => $request->order_id
                ]);

                $order = Order::with(['orderItems.book', 'user'])->findOrFail($request->order_id);

                // DEBUG: Order loaded
                Log::info('📦 Order loaded', [
                    'order_id' => $order->id,
                    'user_id' => $order->user_id,
                    'has_user' => !is_null($order->user),
                    'user_email' => $order->user->email ?? 'null',
                    'status' => $order->status
                ]);

                if ($order->user_id !== auth()->id()) {
                    Log::warning('🚫 Unauthorized payment attempt', [
                        'order_user_id' => $order->user_id,
                        'auth_user_id' => auth()->id(),
                        'order_id' => $order->id
                    ]);

                    return response()->json(['error' => 'Unauthorized'], 403);
                }

                // Update order with more details
                $order->update([
                    'status' => 'paid',
                    'payment_method' => 'stripe',
                    'payment_id' => $paymentIntent->id,
                    'transaction_id' => $paymentIntent->id,
                    'payment_status' => 'paid',
                    'payment_details' => json_encode([
                        'stripe_payment_intent' => $paymentIntent->id,
                        'stripe_status' => $paymentIntent->status,
                        'stripe_amount' => $paymentIntent->amount,
                        'stripe_currency' => $paymentIntent->currency,
                        'verified_at' => now()->toDateTimeString(),
                    ])
                ]);

                Log::info('✅ Order updated for Stripe payment', [
                    'order_id' => $order->id,
                    'status' => 'paid',
                    'payment_intent' => $paymentIntent->id
                ]);

                // Update book stock
                foreach ($order->orderItems as $item) {
                    $book = $item->book;
                    $oldStock = $book->stock;
                    $book->decrement('stock', $item->quantity);
                    $newStock = $book->fresh()->stock;

                    Log::info('📚 Book stock updated', [
                        'book_id' => $book->id,
                        'title' => $book->title,
                        'quantity_sold' => $item->quantity,
                        'old_stock' => $oldStock,
                        'new_stock' => $newStock
                    ]);
                }

                // Send payment success email
                Log::info('📧 Calling sendPaymentSuccessEmail...', [
                    'order_id' => $order->id
                ]);


                session()->forget('cart');
                session()->forget('stripe_order_' . $request->payment_intent_id);
            } catch (ApiErrorException $e) {
                Log::error('❌ Stripe API Error: ' . $e->getMessage(), [
                    'payment_intent_id' => $request->payment_intent_id,
                    'order_id' => $request->order_id,
                    'error' => $e->getError()
                ]);

                return response()->json([
                    'error' => 'Payment verification failed: ' . $e->getMessage()
                ], 500);
            } catch (\Exception $e) {
                Log::error('❌ Payment processing error: ' . $e->getMessage(), [
                    'payment_intent_id' => $request->payment_intent_id,
                    'order_id' => $request->order_id,
                    'trace' => $e->getTraceAsString()
                ]);

                DB::rollBack();
                return response()->json([
                    'error' => 'Payment processing failed: ' . $e->getMessage()
                ], 500);
            }
        });
    }

    // Process Other Payments (bKash, Nagad, Mobile Banking)
    public function processOtherPayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|string|in:bkash,nagad,mobile',
            'mobile_number' => 'required|string|max:15',
            'transaction_id' => 'required|string|max:255',
            'bank' => 'sometimes|string|max:50',
        ]);

        return DB::transaction(function () use ($request) {
            try {
                $order = Order::with(['orderItems.book', 'user'])->findOrFail($request->order_id);

                // Check if order already completed
                if ($order->status === 'completed') {
                    return redirect()->route('payment.order')->with('error', 'This order has already been completed.');
                }

                // Check stock availability
                foreach ($order->orderItems as $item) {
                    if ($item->book->stock < $item->quantity) {
                        return redirect()->back()->with('error', "Insufficient stock for {$item->book->title}. Available: {$item->book->stock}, Requested: {$item->quantity}");
                    }
                }

                // Update order status
                $order->update([
                    'status' => 'payment_submitted',
                    'payment_method' => $request->payment_method,
                    'payment_status' => 'paid',
                    'transaction_id' => $request->transaction_id,
                    'payment_details' => json_encode([
                        'mobile_number' => $request->mobile_number,
                        'bank' => $request->bank ?? null,
                        'verified_at' => now()->toDateTimeString(),
                    ])
                ]);

                // Update book stock
                foreach ($order->orderItems as $item) {
                    $book = $item->book;
                    // $book->decrement('stock', $item->quantity);

                    Log::info("Stock updated for book: {$book->title}", [
                        'book_id' => $book->id,
                        'quantity_sold' => $item->quantity,
                        'remaining_stock' => $book->stock,
                        'order_id' => $order->id
                    ]);
                }

                // Clear cart session
                session()->forget('cart');

                Log::info("Payment processed successfully", [
                    'order_id' => $order->id,
                    'payment_method' => $request->payment_method,
                    'transaction_id' => $request->transaction_id,
                    'amount' => $order->total_amount
                ]);

                return redirect()->route('payment.order')->with('success', 'Payment processed successfully!');
            } catch (\Exception $e) {
                Log::error('Other payment processing failed: ' . $e->getMessage());
                DB::rollBack();

                return redirect()->back()->with('error', 'Payment processing failed: ' . $e->getMessage());
            }
        });
    }

    // Confirm Stripe Payment (for complex order data)
    public function confirmStripePayment(Request $request)
    {
        $request->validate([
            'payment_intent_id' => 'required|string',
            'items' => 'required|array',
            'total_amount' => 'required|numeric|min:0'
        ]);

        return DB::transaction(function () use ($request) {
            try {
                $paymentIntent = PaymentIntent::retrieve($request->payment_intent_id);

                if ($paymentIntent->status !== 'succeeded') {
                    return response()->json([
                        'error' => 'Payment not completed. Status: ' . $paymentIntent->status
                    ], 400);
                }

                // Get items from session first, fallback to request
                $sessionKey = 'stripe_order_' . $request->payment_intent_id;
                $orderData = session($sessionKey);

                if (!$orderData) {
                    $orderData = [
                        'items' => $request->items,
                        'total_amount' => $request->total_amount,
                        'user_id' => auth()->id()
                    ];
                }

                $items = $orderData['items'];

                // Check stock availability
                $stockCheck = $this->checkStockAvailability($items);
                if (!$stockCheck['available']) {
                    return response()->json([
                        'error' => $stockCheck['message']
                    ], 400);
                }

                // Create Order
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'total_amount' => $orderData['total_amount'],
                    'payment_method' => 'stripe',
                    'payment_status' => 'paid',
                    'transaction_id' => $request->payment_intent_id,
                    'status' => 'paid'
                ]);

                // Create Order Items and Update Stock
                foreach ($items as $item) {
                    $book = Book::find($item['id']);

                    if ($book) {
                        OrderItem::create([
                            'order_id' => $order->id,
                            'book_id' => $item['id'],
                            'quantity' => $item['quantity'],
                            'unit_price' => $item['price'],
                            'total_price' => $item['price'] * $item['quantity']
                        ]);

                        // Update book stock
                        $book->decrement('stock', $item['quantity']);
                        $book->save();

                        Log::info("Stock updated for book: {$book->title}", [
                            'book_id' => $book->id,
                            'quantity_sold' => $item['quantity'],
                            'remaining_stock' => $book->stock,
                            'order_id' => $order->id
                        ]);
                    }
                }

                // Load user relationship
                $order->load('user');

                // Clean up session data
                session()->forget($sessionKey);
                session()->forget('cart');

                return response()->json([
                    'success' => true,
                    'order_id' => $order->id,
                    'transaction_id' => $request->payment_intent_id,
                    'message' => 'Stripe payment completed successfully!'
                ]);
            } catch (ApiErrorException $e) {
                Log::error('Stripe confirmation error: ' . $e->getMessage());
                return response()->json(['error' => 'Stripe verification failed'], 500);
            } catch (\Exception $e) {
                Log::error('Payment confirmation failed: ' . $e->getMessage());
                return response()->json(['error' => 'Payment confirmation failed'], 500);
            }
        });
    }

    // For other payment methods (COD, bKash, etc.)
    public function saveOrder(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|string',
        ]);

        return DB::transaction(function () use ($request) {
            try {
                $order = Order::with(['orderItems.book', 'user'])->findOrFail($request->order_id);

                if ($order->user_id !== auth()->id()) {
                    return response()->json(['error' => 'Unauthorized'], 403);
                }

                // Check stock
                foreach ($order->orderItems as $item) {
                    if ($item->book->stock < $item->quantity) {
                        return response()->json([
                            'error' => "Insufficient stock for {$item->book->title}"
                        ], 400);
                    }
                }

                $order->update([
                    'status' => 'paid',
                    'payment_method' => $request->payment_method,
                ]);

                foreach ($order->orderItems as $item) {
                    $book = $item->book;
                    $book->decrement('stock', $item->quantity);
                }

                // Send payment success email 

                session()->forget('cart');

                return response()->json([
                    'success' => true,
                    'order_id' => $order->id,
                    'message' => 'Order completed successfully!'
                ]);
            } catch (\Exception $e) {
                Log::error('Order processing failed: ' . $e->getMessage());
                return response()->json(['error' => 'Order processing failed'], 500);
            }
        });
    }

    // Helper function for stock check
    private function checkStockAvailability($items)
    {
        $outOfStockItems = [];
        $insufficientStockItems = [];

        foreach ($items as $item) {
            $book = Book::find($item['id']);

            if (!$book) {
                $outOfStockItems[] = $item['title'] ?? 'Unknown Book';
                continue;
            }

            if ($book->stock < $item['quantity']) {
                $insufficientStockItems[] = [
                    'title' => $item['title'] ?? $book->title,
                    'requested' => $item['quantity'],
                    'available' => $book->stock
                ];
            }
        }

        if (!empty($outOfStockItems)) {
            return [
                'available' => false,
                'message' => 'Some items are out of stock: ' . implode(', ', $outOfStockItems)
            ];
        }

        if (!empty($insufficientStockItems)) {
            $errorMessage = 'Insufficient stock: ';
            foreach ($insufficientStockItems as $item) {
                $errorMessage .= "{$item['title']} (Available: {$item['available']}, Requested: {$item['requested']}), ";
            }
            $errorMessage = rtrim($errorMessage, ', ');

            return [
                'available' => false,
                'message' => $errorMessage
            ];
        }

        return ['available' => true, 'message' => 'All items in stock'];
    }

    // Initiate Payment (for SSLCommerz and other gateways)
    public function initiatePayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|string',
        ]);

        $order = Order::with('orderItems.book')->findOrFail($request->order_id);

        // Check stock availability
        foreach ($order->orderItems as $item) {
            if ($item->book->stock < $item->quantity) {
                return response()->json([
                    'error' => "Insufficient stock for {$item->book->title}"
                ], 400);
            }
        }

        // For SSLCommerz or other payment gateways
        if ($request->payment_method !== 'stripe') {
            return $this->initiateSSLCommerzPayment($order, $request->payment_method);
        }

        // For Stripe, the frontend will handle it
        return response()->json([
            'success' => true,
            'message' => 'Proceed with Stripe payment'
        ]);
    }

    // In PaymentController.php - Add this method
    public function processCOD(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        return DB::transaction(function () use ($request) {
            try {
                $order = Order::with(['orderItems.book', 'user'])->findOrFail($request->order_id);

                // Check if order already completed
                if ($order->status === 'completed') {
                    return redirect()->route('payment.order')->with('error', 'This order has already been completed.');
                }

                // Check stock availability
                foreach ($order->orderItems as $item) {
                    if ($item->book->stock < $item->quantity) {
                        return redirect()->back()->with('error', "Insufficient stock for {$item->book->title}. Available: {$item->book->stock}, Requested: {$item->quantity}");
                    }
                }

                // Update order status for COD
                $order->update([
                    'status' => 'COD', // Order is pending until delivered
                    'payment_method' => 'cod',
                    'payment_status' => 'pending', // Payment pending until delivery
                    'transaction_id' => 'COD-' . $order->id . '-' . time(),
                    'payment_details' => json_encode([
                        'payment_type' => 'cash_on_delivery',
                        'order_placed_at' => now()->toDateTimeString(),
                        'expected_delivery' => now()->addDays(3)->toDateTimeString(),
                    ])
                ]);

                // Update book stock
                foreach ($order->orderItems as $item) {
                    $book = $item->book;
                    $oldStock = $book->stock;
                    $book->decrement('stock', $item->quantity);
                    $newStock = $book->fresh()->stock;

                    Log::info("📚 Stock updated for book (COD): {$book->title}", [
                        'book_id' => $book->id,
                        'quantity_sold' => $item->quantity,
                        'old_stock' => $oldStock,
                        'new_stock' => $newStock,
                        'order_id' => $order->id,
                        'payment_method' => 'cod'
                    ]);
                }

                // Send COD confirmation email
                $this->sendCODConfirmationEmail($order);

                // Clear cart session
                session()->forget('cart');

                Log::info("✅ COD order placed successfully", [
                    'order_id' => $order->id,
                    'amount' => $order->total_amount,
                    'cart_cleared' => !session()->has('cart')
                ]);

                return redirect()->route('payment.order')->with('success', 'Cash on Delivery order placed successfully! You will pay when you receive the books.');
            } catch (\Exception $e) {
                Log::error('❌ COD processing failed: ' . $e->getMessage());
                DB::rollBack();

                return redirect()->back()->with('error', 'COD order processing failed: ' . $e->getMessage());
            }
        });
    }

    // Add this new email sending method
    private function sendCODConfirmationEmail(Order $order)
    {
        try {
            // Load user relationship if not already loaded
            if (!$order->relationLoaded('user')) {
                $order->load(['user', 'orderItems.book']);
            }

            $user = $order->user;

            if (!$user) {
                Log::error('User not found for COD order', [
                    'order_id' => $order->id,
                    'order_user_id' => $order->user_id
                ]);
                return false;
            }

            // Check email
            if (!$user->email || !filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                Log::error('Invalid or empty email for COD', [
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                    'email' => $user->email
                ]);
                return false;
            }

            Log::info('Sending COD confirmation email', [
                'order_id' => $order->id,
                'to_email' => $user->email,
                'user_name' => $user->name,
                'order_total' => $order->total_amount
            ]);

            // Send COD specific email
            Mail::to($user->email)->send(new CODConfirmationMail($order, $user));

            Log::info('COD confirmation email sent successfully', [
                'order_id' => $order->id,
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send COD confirmation email: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'error_message' => $e->getMessage()
            ]);

            return false;
        }
    }

    // Handle SSLCommerz Webhook
    public function handleSSLCommerzWebhook(Request $request)
    {
        Log::info('SSLCommerz webhook received', $request->all());
        return response()->json(['status' => 'success']);
    }

    public function success()
    {
        return Inertia::render('Shop/PaymentSuccess', [
            'flash' => [
                'success' => session('success'),
                'error' => session('error')
            ]
        ]);
    }
    public function orderSuccess()
    {
        return Inertia::render('Shop/successOrder', [
            'flash' => [
                'success' => session('success'),
                'error' => session('error')
            ]
        ]);
    }

    public function cancel()
    {
        return Inertia::render('Shop/PaymentCancel');
    }
}
