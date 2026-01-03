<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Contact Message - PUSTOK</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .header h1 {
            color: white;
            margin: 0;
            font-size: 24px;
        }
        .content {
            background: #f9fafb;
            padding: 30px;
            border-radius: 0 0 10px 10px;
            border: 1px solid #e5e7eb;
        }
        .info-box {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #e5e7eb;
        }
        .info-label {
            font-weight: 600;
            color: #4b5563;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-value {
            font-size: 16px;
            color: #111827;
            margin-top: 5px;
        }
        .message-box {
            background: white;
            border-radius: 8px;
            padding: 20px;
            border: 1px solid #e5e7eb;
            margin-top: 20px;
        }
        .message {
            white-space: pre-wrap;
            line-height: 1.8;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📬 New Contact Message</h1>
    </div>
    
    <div class="content">
        <div class="info-box">
            <div class="info-label">From</div>
            <div class="info-value">{{ $data['name'] ?? 'N/A' }}</div>
        </div>
        
        <div class="info-box">
            <div class="info-label">Email</div>
            <div class="info-value">{{ $data['email'] ?? 'N/A' }}</div>
        </div>
        
        <div class="info-box">
            <div class="info-label">Subject</div>
            <div class="info-value">{{ $data['subject'] ?? 'Contact Form' }}</div>
        </div>
        
        <div class="message-box">
            <div class="info-label">Message</div>
            <div class="info-value message">{{ $data['message'] ?? 'N/A' }}</div>
        </div>
        
        <div class="footer">
            <p>This message was sent from the contact form on PUSTOK.com</p>
            <p>© {{ date('Y') }} PUSTOK Bookstore. All rights reserved.</p>
        </div>
    </div>
</body>
</html>