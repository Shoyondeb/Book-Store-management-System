<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomMeeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'zoom_meeting_id',
        'topic',
        'agenda',
        'start_time',
        'duration',
        'timezone',
        'password',
        'join_url',
        'start_url',
        'zoom_response',
        'status'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'zoom_response' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function getJoinUrlForIframeAttribute()
    {
        // Transform join URL for iframe embedding
        $joinUrl = $this->join_url;

        // Method 1: Use Zoom Web Client (most reliable without SDK)
        if (strpos($joinUrl, 'zoom.us/j/') !== false) {
            $meetingId = $this->zoom_meeting_id;
            $password = $this->password;

            // Option A: Use Zoom Web Client directly
            return "https://zoom.us/wc/{$meetingId}/join?pwd={$password}";

            // Option B: Use /wc/join endpoint
            // return "https://zoom.us/wc/join/{$meetingId}?pwd={$password}";
        }

        return $joinUrl;
    }
}
