<!DOCTYPE html>
<html>

<head>
    <title>Cash on Delivery Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }

        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }

        .order-details {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .item {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }

        .total {
            font-size: 20px;
            font-weight: bold;
            color: #4CAF50;
            margin-top: 20px;
        }

        .note {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Cash on Delivery Order Confirmed! 📦</h1>
        <p>Order #{{ $order->id }}</p>
    </div>

    <div class="content">
        <p>Dear {{ $user->name }},</p>

        <p>Your Cash on Delivery order has been successfully placed. You'll pay when you receive the books.</p>

        <div class="order-details">
            <h3>Order Details:</h3>
            <p><strong>Order ID:</strong> #{{ $order->id }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
            <p><strong>Payment Method:</strong> Cash on Delivery</p>
            <p><strong>Payment Status:</strong> Pending (Pay on Delivery)</p>

            <h4>Order Items:</h4>
            @foreach($order->orderItems as $item)
            <div class="item">
                <p><strong>{{ $item->book->title }}</strong></p>
                <p>Quantity: {{ $item->quantity }} × ৳{{ number_format($item->price, 2) }}</p>
                <p>Subtotal: ৳{{ number_format($item->total_price, 2) }}</p>
            </div>
            @endforeach

            <div class="total">
                <p>Total Amount: ৳{{ number_format($order->total_amount, 2) }}</p>
                <p>You'll pay this amount when the books are delivered to you.</p>
            </div>
        </div>

        <div class="note">
            <h4>📝 Important Notes:</h4>
            <p>1. Please have exact change ready when the delivery person arrives</p>
            <p>2. Check the books before making the payment</p>
            <p>3. Delivery usually takes 2-3 business days</p>
            <p>4. Our delivery hours are 9:00 AM - 8:00 PM</p>
        </div>

        <p>You'll receive another email with tracking information once your order is shipped.</p>

        <p>Thank you for choosing us!</p>

        <p>Best regards,<br>
            <strong>The BookStore Team</strong>
        </p>

        <hr>
        <p style="text-align: center; color: #666; font-size: 12px;">
            If you have any questions, contact us at support@bookstore.com or call +880 123456789
        </p>
    </div>
</body>

</html>