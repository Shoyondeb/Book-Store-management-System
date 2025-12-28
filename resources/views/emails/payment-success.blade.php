<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
        }

        .header p {
            margin: 10px 0 0;
            font-size: 16px;
            opacity: 0.9;
        }

        .content {
            padding: 30px;
        }

        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .order-info {
            background-color: #f8f9fa;
            border-left: 4px solid #4CAF50;
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 5px 5px 0;
        }

        .order-info h3 {
            margin-top: 0;
            color: #2c3e50;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .info-label {
            font-weight: 600;
            color: #555;
        }

        .info-value {
            color: #333;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .items-table th {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            text-align: left;
        }

        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        .items-table tr:hover {
            background-color: #f5f5f5;
        }

        .total-amount {
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            color: #4CAF50;
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .next-steps {
            background-color: #e8f5e9;
            padding: 20px;
            border-radius: 5px;
            margin: 25px 0;
        }

        .next-steps h3 {
            color: #2e7d32;
            margin-top: 0;
        }

        .next-steps ul {
            padding-left: 20px;
        }

        .next-steps li {
            margin-bottom: 8px;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 14px;
            border-top: 1px solid #eee;
            background-color: #f9f9f9;
        }

        .contact-info {
            margin-top: 15px;
            color: #777;
        }

        .highlight {
            background-color: #fff3cd;
            padding: 10px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 4px solid #ffc107;
        }

        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            margin: 15px 0;
        }

        .button:hover {
            background-color: #45a049;
        }

        @media (max-width: 600px) {
            .container {
                margin: 10px;
            }

            .content {
                padding: 20px;
            }

            .info-row {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Payment Successful!</h1>
            <p>Thank you for your purchase from BookStore</p>
        </div>

        <div class="content">
            <div class="greeting">
                <p>Hello <strong>{{ $user->name }}</strong>,</p>
                <p>We're delighted to inform you that your payment has been successfully processed.</p>
            </div>

            <div class="order-info">
                <h3>Order Details</h3>
                <div class="info-row">
                    <span class="info-label">Order Number:</span>
                    <span class="info-value"><strong>#{{ $order->id }}</strong></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Order Date:</span>
                    <span class="info-value">{{ $order->created_at->format('F d, Y \a\t h:i A') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Payment Method:</span>
                    <span class="info-value">{{ ucfirst($order->payment_method) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Transaction ID:</span>
                    <span class="info-value">{{ $order->transaction_id ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Payment Status:</span>
                    <span class="info-value" style="color: #4CAF50; font-weight: bold;">Paid</span>
                </div>
            </div>

            <h3>Order Items</h3>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->book->title }}</td>
                        <td>{{ $item->quantity }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total-amount">
                Total Amount: ৳{{ number_format($order->total_amount, 2) }}
            </div>

            <div class="next-steps">
                <h3>What's Next?</h3>
                <ul>
                    <li>Your order is being processed and will be shipped soon</li>
                    <li>You will receive another email with tracking information</li>
                    <li>Expected delivery: 3-5 business days</li>
                    <li>You can track your order from your account dashboard</li>
                </ul>

                <a href="{{ route('orders.show', $order->id) }}" class="button">View Order Details</a>
            </div>

            <div class="highlight">
                <p><strong>Need Help?</strong></p>
                <p>If you have any questions about your order, please contact our customer support team.</p>
            </div>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <div class="contact-info">
                <p>Email: support@{{ config('app.domain', 'example.com') }} | Phone: {{ config('app.phone', '+880 XXXX-XXXXXX') }}</p>
                <p>Address: {{ config('app.address', 'Your Business Address') }}</p>
            </div>
            <p>This is an automated email. Please do not reply to this message.</p>
        </div>
    </div>
</body>

</html>