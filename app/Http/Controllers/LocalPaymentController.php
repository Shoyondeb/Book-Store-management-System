<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Book;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LocalPaymentController extends Controller
{
    public function processLocalPayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|string|in:bkash,nagad,mobile',
            'mobile_number' => 'required|string|max:15',
            'transaction_id' => 'required|string|max:100',
            'bank' => 'sometimes|string|max:50',
        ]);

        return DB::transaction(function () use ($request) {
            try {
                $order = Order::with('orderItems.book')->findOrFail($request->order_id);

                // Check if order already paid
                if ($order->payment_status === 'paid') {
                    return response()->json([
                        'success' => false,
                        'error' => 'Order already paid'
                    ], 400);
                }

                // Check stock availability
                foreach ($order->orderItems as $item) {
                    if ($item->book->stock < $item->quantity) {
                        return response()->json([
                            'success' => false,
                            'error' => "Insufficient stock for {$item->book->title}. Available: {$item->book->stock}, Requested: {$item->quantity}"
                        ], 400);
                    }
                }

                // Prepare payment details for JSON storage
                $paymentDetails = [
                    'mobile_number' => $request->mobile_number,
                    'transaction_id' => $request->transaction_id,
                    'paid_at' => now()->toDateTimeString(),
                ];

                if ($request->filled('bank')) {
                    $paymentDetails['bank'] = $request->bank;
                }

                // Update order with payment information
                $order->update([
                    'status' => 'completed',
                    'payment_method' => $request->payment_method,
                    'payment_details' => json_encode($paymentDetails),
                    'transaction_id' => $request->transaction_id,
                    'payment_status' => 'paid',
                ]);

                Log::info('✅ Order payment details updated', [
                    'order_id' => $order->id,
                    'payment_method' => $request->payment_method,
                    'transaction_id' => $request->transaction_id
                ]);

                // Update book stock
                foreach ($order->orderItems as $orderItem) {
                    $book = $orderItem->book;

                    if ($book) {
                        $oldStock = $book->stock;
                        $book->stock -= $orderItem->quantity;
                        $book->save();

                        Log::info('✅ Book stock updated', [
                            'book_id' => $book->id,
                            'title' => $book->title,
                            'old_stock' => $oldStock,
                            'new_stock' => $book->stock,
                            'quantity_sold' => $orderItem->quantity
                        ]);
                    } else {
                        Log::error('❌ Book not found for order item', [
                            'order_item_id' => $orderItem->id,
                            'book_id' => $orderItem->book_id
                        ]);
                        throw new \Exception("Book not found for order item: {$orderItem->book_id}");
                    }
                }

                // Clear cart session
                session()->forget('cart');

                Log::info('🎉 Local payment completed successfully', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'payment_method' => $request->payment_method,
                    'transaction_id' => $request->transaction_id,
                    'amount' => $order->total_amount
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Payment completed successfully!',
                    'order_id' => $order->id,
                    'order_number' => $order->order_number
                ]);
            } catch (\Exception $e) {
                Log::error('💥 Local payment processing failed: ' . $e->getMessage(), [
                    'order_id' => $request->order_id,
                    'payment_method' => $request->payment_method,
                    'transaction_id' => $request->transaction_id
                ]);

                return response()->json([
                    'success' => false,
                    'error' => 'Payment processing failed: ' . $e->getMessage()
                ], 500);
            }
        });
    }

    public function verifyTransaction(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|string',
            'payment_method' => 'required|string|in:bkash,nagad,mobile',
        ]);

        try {
            // Check if transaction ID already exists in orders table
            $existingOrder = Order::where('transaction_id', $request->transaction_id)
                ->where('payment_method', $request->payment_method)
                ->where('payment_status', 'paid')
                ->first();

            if ($existingOrder) {
                return response()->json([
                    'success' => false,
                    'error' => 'Transaction ID already used for order #' . $existingOrder->order_number
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Transaction ID is valid and available'
            ]);
        } catch (\Exception $e) {
            Log::error('Transaction verification failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Transaction verification failed'
            ], 500);
        }
    }
}
