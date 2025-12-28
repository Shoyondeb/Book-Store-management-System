<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: #3b82f6;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .content {
            background: #f9fafb;
            padding: 20px;
        }

        .order-details {
            background: white;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>📚 BookStore</h1>
            <h2>Order Confirmed!</h2>
        </div>

        <div class="content">
            <p>Hello {{ $order->user->name }},</p>
            <p>Thank you for your order! We're preparing your books for shipment.</p>

            <div class="order-details">
                <h3>Order Details</h3>
                <p><strong>Order Number:</strong> #{{ $order->order_number }}</p>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('F j, Y') }}</p>
                <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                <p><strong>Status:</strong> <span style="color: #3b82f6; font-weight: bold;">{{ ucfirst($order->status) }}</span></p>
            </div>

            <h3>Items Ordered:</h3>
            @foreach($order->orderItems as $item)
            <div style="display: flex; align-items: center; margin-bottom: 10px; padding: 10px; background: white; border-radius: 5px;">
                <div style="flex: 1;">
                    <strong>{{ $item->book->title }}</strong><br>
                    <small>by {{ $item->book->author->name }}</small>
                </div>
                <div style="text-align: right;">
                    <div>Qty: {{ $item->quantity }}</div>
                    <div>${{ number_format($item->price * $item->quantity, 2) }}</div>
                </div>
            </div>
            @endforeach

            <div style="text-align: center; margin: 20px 0;">
                <a href="{{ url('/orders/' . $order->id) }}"
                    style="background: #3b82f6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;">
                    View Order Details
                </a>
            </div>
        </div>

        <div class="footer">
            <p>If you have any questions, please contact our support team.</p>
            <p>&copy; {{ date('Y') }} BookStore. All rights reserved.</p>
        </div>
    </div>
</body>

</html>