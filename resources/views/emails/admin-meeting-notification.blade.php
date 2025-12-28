<!DOCTYPE html>
<html>

<head>
    <title>New Meeting Scheduled - You are the Host</title>
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
            background-color: #4F46E5;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .content {
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #eae9efff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .info-box {
            background-color: #e0f2fe;
            border-left: 4px solid #0ea5e9;
            padding: 15px;
            margin: 20px 0;
        }

        .host-badge {
            background-color: #fef3c7;
            color: #92400e;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🎯 You Have a New Meeting Scheduled</h1>
            <p>You are the <strong>Host/Admin</strong> of this meeting</p>
        </div>

        <div class="content">
            <div class="host-badge">HOST</div>

            <h2>Meeting Details:</h2>

            <div class="info-box">
                <p><strong>Topic:</strong> {{ $meeting->topic }}</p>
                <p><strong>Date & Time:</strong> {{ \Carbon\Carbon::parse($meeting->start_time)->format('F j, Y, g:i a T') }}</p>
                <p><strong>Duration:</strong> {{ $meeting->duration }} minutes</p>
                <p><strong>Timezone:</strong> {{ $meeting->timezone }}</p>
                @if($meeting->agenda)
                <p><strong>Agenda:</strong> {{ $meeting->agenda }}</p>
                @endif
            </div>

            <h3>🔑 Host Information:</h3>
            <ul>
                <li><strong>Meeting ID:</strong> {{ $meeting->zoom_meeting_id }}</li>
                <li><strong>Password:</strong> {{ $meeting->password }}</li>
                <li><strong>Link Type:</strong> <span style="color: #dc2626; font-weight: bold;">{{ $linkType }} (Host Access)</span></li>
            </ul>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $joinUrl }}" class="button" style="background-color: #240985ff;">
                    🚀 {{ $isHost ? 'Start Meeting as Host' : 'Join Meeting' }}
                </a>
                <p style="font-size: 12px; color: #666; margin-top: 10px;">
                    This is your <strong>host link</strong> - only you can start the meeting with this link
                </p>
            </div>

            <h3>📋 Additional Information:</h3>
            <p>As the host, you can:</p>
            <ul>
                <li>Start the meeting at any time</li>
                <li>Manage participants</li>
                <li>Record the meeting</li>
                <li>Control screen sharing</li>
            </ul>

            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; font-size: 12px; color: #666;">
                <p>This meeting was scheduled by: {{ $meeting->user->name ?? 'User' }}</p>
                <p>If the button doesn't work, copy and paste this link in your browser:<br>
                    <code style="background-color: #f1f1f1; padding: 5px; display: inline-block; margin-top: 5px;">{{ $joinUrl }}</code>
                </p>
            </div>
        </div>
    </div>
</body>

</html>