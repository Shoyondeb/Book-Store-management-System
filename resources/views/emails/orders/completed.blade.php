<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Completed</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 700px;
            background: #ffffff;
            margin: auto;
            border-radius: 6px;
            overflow: hidden;
        }

        .header {
            background: #4CAF50;
            color: #fff;
            text-align: center;
            padding: 20px;
        }

        .content {
            padding: 20px;
            color: #333;
        }

        h3 {
            margin-top: 25px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 6px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background: #f0f0f0;
        }

        .total {
            text-align: right;
            font-weight: bold;
            margin-top: 10px;
        }

        .footer {
            text-align: center;
            font-size: 13px;
            color: #777;
            padding: 15px;
            background: #f9f9f9;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="header">
            <h2>🎉 Order Completed</h2>
            <p>Thank you for your purchase</p>
        </div>

        <div class="content">

            <p>Hello <strong>{{ $user->name }}</strong>,</p>
            <p>Your order has been successfully completed.</p>

            <h3>Order Summary</h3>
            <div class="info-row">
                <span>Order Number:</span>
                <span>#{{ $order->order_number }}</span>
            </div>
            <div class="info-row">
                <span>Order Date:</span>
                <span>{{ $order->created_at->format('F d, Y') }}</span>
            </div>
            <div class="info-row">
                <span>Status:</span>
                <span style="color:green;">Completed</span>
            </div>

            <h3>Items</h3>
            <table>
                <thead>
                    <tr>
                        <th>Book</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->book->title }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>৳{{ number_format($item->price, 2) }}</td>
                        <td>৳{{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <p class="total">
                Grand Total: ৳{{ number_format($order->total_amount, 2) }}
            </p>

            <p>📚 Enjoy your books and happy reading!</p>

        </div>

        <div class="footer">
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>

    </div>

</body>

</html>