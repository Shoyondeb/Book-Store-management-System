<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ZoomMeeting;

class ZoomMeetingPolicy
{
    public function view(User $user, ZoomMeeting $meeting): bool
    {
        return $user->id === $meeting->customer_id ||
            $user->id === $meeting->admin_id ||
            $user->role === 'admin';
    }

    public function create(User $user): bool
    {
        return $user->role === 'customer';
    }

    public function update(User $user, ZoomMeeting $meeting): bool
    {
        return $user->id === $meeting->customer_id &&
            $meeting->start_time->isFuture();
    }

    public function delete(User $user, ZoomMeeting $meeting): bool
    {
        return $user->id === $meeting->customer_id &&
            $meeting->start_time->subHours(1)->isFuture(); // Can cancel up to 1 hour before
    }

    public function start(User $user, ZoomMeeting $meeting): bool
    {
        return $user->id === $meeting->admin_id;
    }
}
