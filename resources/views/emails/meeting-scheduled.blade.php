{{-- resources/views/emails/meeting-scheduled.blade.php --}}
<!DOCTYPE html>
<html>

<head>
    <title>Meeting Scheduled</title>
</head>

<body>
    <h2>Your Zoom Meeting Has Been Scheduled</h2>

    <p>Hello {{ $user->name }},</p>

    <p>Your meeting has been successfully scheduled with {{ $meeting->admin->name }}.</p>

    <h3>Meeting Details:</h3>
    <ul>
        <li><strong>Topic:</strong> {{ $meeting->topic }}</li>
        <li><strong>Date & Time:</strong> {{ $meeting->start_time->format('F j, Y, g:i a T') }}</li>
        <li><strong>Duration:</strong> {{ $meeting->duration }} minutes</li>
        <li><strong>Agenda:</strong> {{ $meeting->agenda ?? 'No agenda provided' }}</li>
        <li><strong>Meeting ID:</strong> {{ $meeting->zoom_meeting_id }}</li>
        <li><strong>Password:</strong> {{ $meeting->password }}</li>
    </ul>

    <h3>Join the Meeting:</h3>
    <p>
        <a href="{{ $meeting->join_url }}" style="padding: 10px 20px; background-color: #2D8CFF; color: white; text-decoration: none; border-radius: 5px;">
            Join Zoom Meeting
        </a>
    </p>

    <p>Or copy this link: {{ $meeting->join_url }}</p>

    <p>Best regards,<br>Book Store Management System</p>
</body>

</html>