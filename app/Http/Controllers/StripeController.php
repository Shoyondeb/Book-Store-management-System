<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\Book;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Order;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentSuccessMail;

class StripeController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        try {
            $request->validate([
                'order_id' => 'required|exists:orders,id',
                'amount' => 'required|numeric|min:1',
            ]);

            Stripe::setApiKey(config('services.stripe.secret'));

            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount * 100,
                'currency' => 'bdt',
                'metadata' => ['order_id' => $request->order_id]
            ]);

            // ✅ Return JSON response instead of back()
            return response()->json([
                'client_secret' => $paymentIntent->client_secret,
                'payment_intent_id' => $paymentIntent->id
            ]);
        } catch (\Exception $e) {
            \Log::error('Stripe Payment Intent Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Payment processing failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_intent_id' => 'required|string',
        ]);

        try {
            Log::info('🔄 Starting order update', ['order_id' => $request->order_id]);

            // Use 'orderItems' (camelCase) instead of 'order_items'
            $order = Order::with(['orderItems.book', 'user'])->findOrFail($request->order_id);

            Log::info('✅ Order found', [
                'order_id' => $order->id,
                'items_count' => $order->orderItems->count(),
                'user_id' => $order->user_id
            ]);

            // Update order status
            $order->update([
                'status' => 'paid',
                'payment_status' => 'paid',
                'payment_method' => 'stripe',
                'transaction_id' => $request->payment_intent_id,
            ]);

            Log::info('✅ Order status updated');

            // UPDATE BOOK STOCK - use orderItems (camelCase)
            foreach ($order->orderItems as $orderItem) {
                Log::info('Processing order item', [
                    'book_id' => $orderItem->book_id,
                    'quantity' => $orderItem->quantity
                ]);

                $book = $orderItem->book;

                if ($book) {
                    Log::info('Book found', [
                        'book_id' => $book->id,
                        'title' => $book->title,
                        'current_stock' => $book->stock
                    ]);

                    // Update stock
                    $book->stock -= $orderItem->quantity;
                    $book->save();

                    Log::info('✅ Stock updated', [
                        'new_stock' => $book->stock
                    ]);
                } else {
                    Log::error('❌ Book not found', ['book_id' => $orderItem->book_id]);
                }
            }

            // ✅ SEND PAYMENT CONFIRMATION EMAIL
            $emailSent = $this->sendPaymentSuccessEmail($order);

            Log::info('📧 Email sending result', [
                'order_id' => $order->id,
                'email_sent' => $emailSent ? 'Yes' : 'No'
            ]);

            // ✅ CLEAR THE CART SESSION
            session()->forget('cart');

            // ✅ Return success response with email status
            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'email_sent' => $emailSent,
                'message' => $emailSent
                    ? 'Payment completed successfully! Confirmation email sent.'
                    : 'Payment completed successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('💥 Order update failed: ' . $e->getMessage(), [
                'order_id' => $request->order_id,
                'error_trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Order update failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send payment success email
     */
    private function sendPaymentSuccessEmail(Order $order)
    {
        try {
            // Load user relationship if not already loaded
            if (!$order->relationLoaded('user')) {
                $order->load(['user']);
            }

            $user = $order->user;

            if (!$user) {
                Log::error('User not found for order', [
                    'order_id' => $order->id,
                    'order_user_id' => $order->user_id
                ]);
                return false;
            }

            if (!$user->email || !filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                Log::error('Invalid or empty email', [
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                    'email' => $user->email
                ]);
                return false;
            }

            Log::info('📧 Sending payment confirmation email', [
                'order_id' => $order->id,
                'to_email' => $user->email,
                'user_name' => $user->name,
                'order_total' => $order->total_amount
            ]);

            // Option A: Send immediately (bypass queue)
            Mail::to($user->email)->send(new PaymentSuccessMail($order, $user));

            // Option B: If you want to keep queue but check if it works
            // Mail::to($user->email)->queue(new PaymentSuccessMail($order, $user));

            // For immediate sending during testing, you can also do:
            // $mail = new PaymentSuccessMail($order, $user);
            // Mail::send($mail->build());

            Log::info('✅ Payment confirmation email sent successfully', [
                'order_id' => $order->id,
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('❌ Failed to send payment success email: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return false;
        }
    }
}
