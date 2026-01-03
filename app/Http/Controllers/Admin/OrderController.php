<?php
// app/Http/Controllers/Admin/OrderController.php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Mail\OrderShippedMail;
use App\Mail\OrderCompletedMail;
use App\Mail\PaymentSuccessMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function list(Request $request)
    {
        // Get the per_page value from request, default to 10
        $perPage = $request->input('per_page', 10);

        // Validate it's a positive number
        $perPage = max(1, min(100, (int)$perPage));

        $orders = Order::with(['user', 'orderItems.book.author', 'shippingAddress'])
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        // Get total statistics across ALL orders (not just paginated)
        $totalOrders = Order::count();
        $totalCompletedOrders = Order::where('status', 'completed')->count();
        $totalPaymentSubmittedOrders = Order::where('status', 'payment_submitted')->count();
        $totalRevenue = (float) Order::where('status', 'completed')->sum('total_amount');

        return Inertia::render('Admin/Orders/Index', [
            'orders' => $orders,
            'per_page' => $perPage,
            'total_orders_count' => $totalOrders,
            'total_completed_orders_count' => $totalCompletedOrders,
            'total_payment_submitted_orders_count' => $totalPaymentSubmittedOrders,
            'total_revenue' => $totalRevenue,
        ]);
    }

    // Keep index() for backward compatibility
    public function index()
    {
        return $this->list(request());
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,payment_submitted,payment_verification,paid,processing,shipped,ready_for_pickup,completed,cancelled,payment_failed,cod'
        ]);

        try {
            $oldStatus = $order->status;
            $newStatus = $request->status;

            Log::info('📧 DEBUG: Order status update attempt', [
                'order_id' => $order->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'user_id' => $order->user_id
            ]);

            $order->update([
                'status' => $newStatus
            ]);

            // Send emails based on status changes
            if ($oldStatus !== $newStatus) {
                Log::info('📧 DEBUG: Status changed, checking email triggers', [
                    'order_id' => $order->id,
                    'old' => $oldStatus,
                    'new' => $newStatus
                ]);

                // Send email only for ready_for_pickup
                if ($newStatus === 'ready_for_pickup' && $oldStatus !== 'ready_for_pickup') {
                    Log::info('📧 DEBUG: Triggering ready_for_pickup email', [
                        'order_id' => $order->id
                    ]);
                    $emailSent = $this->sendReadyForPickupEmail($order);
                    Log::info('📧 DEBUG: Order ready_for_pickup email result', [
                        'order_id' => $order->id,
                        'email_sent' => $emailSent
                    ]);
                }

                // Send completion email for completed
                if ($newStatus === 'completed' && $oldStatus !== 'completed') {
                    Log::info('📧 DEBUG: Triggering completed email', [
                        'order_id' => $order->id
                    ]);
                    $emailSent = $this->sendOrderCompletedEmail($order);
                    Log::info('📧 DEBUG: Order completed email result', [
                        'order_id' => $order->id,
                        'email_sent' => $emailSent
                    ]);
                }
            }

            // Return success (Inertia will handle the redirect/reload)
            return redirect()->back()->with('success', 'Order status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Order status update failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'Failed to update order status. Please try again.');
        }
    }

    private function sendReadyForPickupEmail(Order $order)
    {
        try {
            $order->load(['user']);
            $user = $order->user;

            if (!$user || !$user->email || !filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                Log::error('📧 Order ready for pickup email: Invalid user or email', [
                    'order_id' => $order->id,
                    'user_id' => $user->id ?? null,
                    'email' => $user->email ?? null
                ]);
                return false;
            }

            // Debug logging
            Log::info('📧 Sending order ready for pickup email', [
                'order_id' => $order->id,
                'to_email' => $user->email,
                'user_name' => $user->name
            ]);

            // Send email
            Mail::to($user->email)->send(new OrderShippedMail($order, $user));

            Log::info('✅ Order ready for pickup email sent successfully', [
                'order_id' => $order->id,
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('❌ Failed to send order ready for pickup email: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Send order completed email
     */
    private function sendOrderCompletedEmail(Order $order)
    {
        try {
            $order->load(['user']);
            $user = $order->user;

            if (!$user || !$user->email || !filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                Log::error('📧 Order completed email: Invalid user or email', [
                    'order_id' => $order->id,
                    'user_id' => $user->id ?? null,
                    'email' => $user->email ?? null
                ]);
                return false;
            }

            // Debug logging
            Log::info('📧 Sending order completed email', [
                'order_id' => $order->id,
                'to_email' => $user->email,
                'user_name' => $user->name
            ]);

            // Send email - you need to create this Mail class
            Mail::to($user->email)->send(new OrderCompletedMail($order, $user));

            Log::info('✅ Order completed email sent successfully', [
                'order_id' => $order->id,
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('❌ Failed to send order completed email: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Verify a payment (for payment_submitted orders)
     */
    public function verifyPayment(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:paid,payment_failed'
        ]);

        try {
            DB::transaction(function () use ($request, $order) {
                $oldStatus = $order->status;
                $newStatus = $request->status;

                // Update order status
                $order->update([
                    'status' => $newStatus,
                    'payment_verified_at' => now(),
                    'payment_verified_by' => auth()->id(),
                ]);

                // If payment is verified, update stock
                if ($newStatus === 'paid') {
                    foreach ($order->orderItems as $item) {
                        $item->book->decrement('stock', $item->quantity);
                    }

                    Log::info('Payment verified successfully', [
                        'order_id' => $order->id,
                        'amount' => $order->total_amount,
                        'verified_by' => auth()->user()->name,
                    ]);
                } else {
                    Log::info('Payment rejected', [
                        'order_id' => $order->id,
                        'amount' => $order->total_amount,
                        'rejected_by' => auth()->user()->name,
                    ]);
                }
            });

            // Refresh the order to get fresh data
            $order->refresh();

            // Send email only when status changes to 'paid'
            if ($request->status === 'paid') {
                $emailSent = $this->sendPaymentSuccessEmail($order);

                $message = $emailSent
                    ? 'Payment verified and confirmation email sent successfully!'
                    : 'Payment verified but email could not be sent.';

                Log::info('Payment verification completed with email attempt', [
                    'order_id' => $order->id,
                    'email_sent' => $emailSent,
                    'admin_id' => auth()->id()
                ]);

                // Return with success message
                return redirect()->back()->with('success', $message);
            } else {
                return redirect()->back()->with('info', 'Payment rejected.');
            }
        } catch (\Exception $e) {
            Log::error('Payment verification failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'Failed to verify payment. Please try again.');
        }
    }

    /**
     * Send payment success email (same as PaymentController)
     */
    private function sendPaymentSuccessEmail(Order $order)
    {
        try {
            // Load the user relationship
            $order->load(['user']);
            $user = $order->user;

            if (!$user) {
                Log::error('📧 DEBUG: User not found for order', [
                    'order_id' => $order->id,
                    'order_user_id' => $order->user_id
                ]);
                return false;
            }

            // Check email
            if (!$user->email || !filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                Log::error('📧 DEBUG: Invalid or empty email', [
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                    'email' => $user->email
                ]);
                return false;
            }

            // Debug mail configuration
            Log::info('📧 DEBUG: Admin sending payment confirmation email', [
                'order_id' => $order->id,
                'to_email' => $user->email,
                'user_name' => $user->name,
                'order_total' => $order->total_amount,
                'admin_id' => auth()->id()
            ]);

            // Send email
            Mail::to($user->email)->send(new PaymentSuccessMail($order, $user));

            Log::info('✅ Admin payment confirmation email sent successfully', [
                'order_id' => $order->id,
                'user_id' => $user->id,
                'email' => $user->email,
                'admin_id' => auth()->id()
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('❌ Admin failed to send payment success email: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'admin_id' => auth()->id(),
                'error_message' => $e->getMessage()
            ]);

            // Don't throw the error - email failure shouldn't break the verification flow
            return false;
        }
    }
}
