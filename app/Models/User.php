<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Order relationships
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Zoom Meeting relationships
    public function customerMeetings()
    {
        return $this->hasMany(ZoomMeeting::class, 'customer_id');
    }

    public function adminMeetings()
    {
        return $this->hasMany(ZoomMeeting::class, 'admin_id');
    }

    // Get all meetings (both as customer and admin)
    public function meetings()
    {
        $customerMeetings = $this->customerMeetings;
        $adminMeetings = $this->adminMeetings;

        return $customerMeetings->merge($adminMeetings);
    }

    // Zoom Participant relationships
    public function zoomParticipants()
    {
        return $this->hasMany(ZoomParticipant::class);
    }

    // Get upcoming meetings
    public function upcomingMeetings()
    {
        return $this->meetings()->where('start_time', '>', now())
            ->where('status', 'scheduled')
            ->orderBy('start_time', 'asc');
    }

    // Get past meetings
    public function pastMeetings()
    {
        return $this->meetings()->where(function ($query) {
            $query->where('start_time', '<', now())
                ->orWhere('status', 'ended');
        })->orderBy('start_time', 'desc');
    }

    // Get meetings as host (admin)
    public function hostedMeetings()
    {
        return $this->adminMeetings()->where('status', '!=', 'cancelled');
    }

    // Get meetings as attendee (customer)
    public function attendedMeetings()
    {
        return $this->customerMeetings()->where('status', '!=', 'cancelled');
    }

    // Check if user has any scheduled meetings
    public function hasScheduledMeetings()
    {
        return $this->meetings()->where('status', 'scheduled')->exists();
    }

    // Get the next scheduled meeting
    public function nextMeeting()
    {
        return $this->meetings()->where('status', 'scheduled')
            ->where('start_time', '>', now())
            ->orderBy('start_time', 'asc')
            ->first();
    }

    // Role checks
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isCustomer()
    {
        return $this->role === 'customer';
    }

    public function isAuthor()
    {
        return $this->role === 'author';
    }

    // Check if user can host meetings (admins and authors)
    public function canHostMeetings()
    {
        return $this->role === 'admin' || $this->role === 'author';
    }

    // Get available hosts (admins and authors)
    public static function getMeetingHosts()
    {
        return self::whereIn('role', ['admin', 'author'])
            ->where('email_verified_at', '!=', null)
            ->orderBy('name')
            ->get();
    }

    // Get available hosts with their upcoming meeting count
    public static function getMeetingHostsWithAvailability()
    {
        return self::whereIn('role', ['admin', 'author'])
            ->where('email_verified_at', '!=', null)
            ->withCount(['adminMeetings as upcoming_meetings_count' => function ($query) {
                $query->where('status', 'scheduled')
                    ->where('start_time', '>', now());
            }])
            ->orderBy('name')
            ->get()
            ->map(function ($host) {
                $host->availability = $host->upcoming_meetings_count < 5 ? 'Available' : 'Limited';
                return $host;
            });
    }

    // Check if user can schedule a meeting with this host
    public function canScheduleWithHost($hostId)
    {
        // Customer can only schedule with admins/authors
        if (!$this->isCustomer()) {
            return false;
        }

        $host = self::find($hostId);
        if (!$host || !$host->canHostMeetings()) {
            return false;
        }

        // Check if host has too many upcoming meetings
        $upcomingMeetings = $host->adminMeetings()
            ->where('status', 'scheduled')
            ->where('start_time', '>', now())
            ->count();

        return $upcomingMeetings < 10; // Max 10 upcoming meetings per host
    }

    // Get user's role for Zoom meetings
    public function getZoomRole($meeting)
    {
        if ($meeting instanceof ZoomMeeting) {
            return $meeting->admin_id === $this->id ? 'host' : 'attendee';
        }

        // If meeting ID is passed
        $meeting = ZoomMeeting::find($meeting);
        if ($meeting) {
            return $meeting->admin_id === $this->id ? 'host' : 'attendee';
        }

        return 'attendee';
    }

    // Check if user has joined a specific meeting
    public function hasJoinedMeeting($meetingId)
    {
        return $this->zoomParticipants()
            ->where('zoom_meeting_id', $meetingId)
            ->whereNotNull('joined_at')
            ->exists();
    }

    // Get user's meeting statistics
    public function getMeetingStats()
    {
        return [
            'total_meetings' => $this->meetings()->count(),
            'upcoming_meetings' => $this->upcomingMeetings()->count(),
            'past_meetings' => $this->pastMeetings()->count(),
            'hosted_meetings' => $this->hostedMeetings()->count(),
            'attended_meetings' => $this->attendedMeetings()->count(),
        ];
    }

    // Get user's calendar for meeting scheduling
    public function getMeetingCalendar($month = null, $year = null)
    {
        $month = $month ?? now()->month;
        $year = $year ?? now()->year;

        $meetings = $this->adminMeetings()
            ->whereYear('start_time', $year)
            ->whereMonth('start_time', $month)
            ->where('status', 'scheduled')
            ->get(['id', 'topic', 'start_time', 'duration', 'customer_id'])
            ->groupBy(function ($meeting) {
                return $meeting->start_time->format('Y-m-d');
            });

        return $meetings;
    }

    // Check if user is available at a specific time
    public function isAvailableAt($startTime, $duration = 30)
    {
        $endTime = (clone $startTime)->addMinutes($duration);

        // Check if user has any meetings overlapping with this time
        $conflictingMeetings = $this->meetings()
            ->where('status', 'scheduled')
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhere(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<', $startTime)
                            ->whereRaw('DATE_ADD(start_time, INTERVAL duration MINUTE) > ?', [$startTime]);
                    });
            })
            ->exists();

        return !$conflictingMeetings;
    }

    // Scope for users who can host meetings
    public function scopeMeetingHosts($query)
    {
        return $query->whereIn('role', ['admin', 'author']);
    }

    // Scope for customers only
    public function scopeCustomers($query)
    {
        return $query->where('role', 'customer');
    }

    // Get user's display name for meetings
    public function getMeetingDisplayName()
    {
        return $this->name . ' (' . ucfirst($this->role) . ')';
    }

    // Get user's initials for avatar
    public function getInitials()
    {
        $names = explode(' ', $this->name);
        $initials = '';

        foreach ($names as $name) {
            $initials .= strtoupper(substr($name, 0, 1));
            if (strlen($initials) >= 2) break;
        }

        return $initials;
    }

    // Get user's upcoming meeting schedule
    public function getUpcomingSchedule($days = 7)
    {
        return $this->meetings()
            ->where('status', 'scheduled')
            ->where('start_time', '>', now())
            ->where('start_time', '<=', now()->addDays($days))
            ->orderBy('start_time', 'asc')
            ->get([
                'id',
                'topic',
                'start_time',
                'duration',
                'customer_id',
                'admin_id',
                'join_url'
            ]);
    }

    // Add this method to your User model
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    // In your User model
    public function defaultAddress()
    {
        return $this->hasOne(Address::class)->where('is_default', true)->latest();
    }
}
