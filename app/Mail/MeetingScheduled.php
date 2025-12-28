<?php

namespace App\Mail;

use App\Models\ZoomMeeting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MeetingScheduled extends Mailable
{
    use Queueable, SerializesModels;

    public $meeting;

    public function __construct(ZoomMeeting $meeting)
    {
        $this->meeting = $meeting;
    }

    public function build()
    {
        return $this->subject('Your Zoom Meeting Scheduled Successfully')
            ->view('emails.meeting-scheduled')
            ->with([
                'meeting' => $this->meeting,
                'user' => $this->meeting->user
            ]);
    }
}
