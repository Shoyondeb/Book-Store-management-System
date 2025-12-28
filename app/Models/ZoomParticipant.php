<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ZoomParticipant extends Model
{
    protected $fillable = [
        'zoom_meeting_id',
        'user_id',
        'role',
        'joined_at',
        'left_at',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'left_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function meeting(): BelongsTo
    {
        return $this->belongsTo(ZoomMeeting::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Methods
     */
    public function markAsJoined(): void
    {
        $this->update(['joined_at' => now()]);
    }

    public function markAsLeft(): void
    {
        $this->update(['left_at' => now()]);
    }

    public function isCurrentlyJoined(): bool
    {
        return $this->joined_at && !$this->left_at;
    }
}
