<?php
// app/Models/Meeting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'host_id',
        'book_id',
        'title',
        'description',
        'scheduled_date',
        'scheduled_time',
        'duration',
        'timezone',
        'zoom_meeting_id',
        'zoom_join_url',
        'zoom_start_url',
        'zoom_password',
        'status',
        'amount',
        'payment_status',
        'meeting_type'
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'amount' => 'decimal:2',
    ];

    // Customer who booked the meeting
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Author/Admin hosting the meeting
    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    // Related book (optional)
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Check if meeting can be joined (within time range)
    public function canJoin()
    {
        try {
            $meetingDateTime = \Carbon\Carbon::parse(
                $this->scheduled_date->format('Y-m-d') . ' ' . $this->scheduled_time,
                $this->timezone
            );

            // Use copy() to avoid modifying the original
            $startTime = $meetingDateTime->copy()->subMinutes(5); // Allow 5 minutes early
            $endTime = $meetingDateTime->copy()->addMinutes($this->duration + 15); // Allow 15 minutes overtime

            $now = \Carbon\Carbon::now($this->timezone);

            // Also check if meeting status is scheduled
            return $now->between($startTime, $endTime) && $this->status === 'scheduled';
        } catch (\Exception $e) {
            return false;
        }
    }

    // Check if meeting is upcoming
    public function isUpcoming()
    {
        try {
            $meetingDateTime = \Carbon\Carbon::parse(
                $this->scheduled_date->format('Y-m-d') . ' ' . $this->scheduled_time,
                $this->timezone
            );

            $now = \Carbon\Carbon::now($this->timezone);

            // Check if meeting is in the future AND status is scheduled
            return $now->lessThan($meetingDateTime) && $this->status === 'scheduled';
        } catch (\Exception $e) {
            return false;
        }
    }
}
