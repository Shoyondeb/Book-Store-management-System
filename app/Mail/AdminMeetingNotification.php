<?php

namespace App\Mail;

use App\Models\ZoomMeeting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminMeetingNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $meeting;
    public $adminName;
    public $isHost;
    public $joinUrl;
    public $linkType;

    public function __construct(ZoomMeeting $meeting)
    {
        $this->meeting = $meeting;

        // Load relationships if not loaded
        if (!$meeting->relationLoaded('admin')) {
            $meeting->load('admin');
        }
        if (!$meeting->relationLoaded('user')) {
            $meeting->load('user');
        }

        $this->adminName = $meeting->admin ? $meeting->admin->name : 'Admin';
        $this->isHost = true;

        // Admin gets start_url (host link) if available, otherwise join_url
        $this->joinUrl = $meeting->start_url ?? $meeting->join_url;
        $this->linkType = $meeting->start_url ? 'Host/Start Link' : 'Join Link';
    }

    public function build()
    {
        return $this->subject('📅 New Meeting Scheduled (You are Host) - ' . $this->meeting->topic)
            ->view('emails.admin-meeting-notification')
            ->with([
                'meeting' => $this->meeting,
                'adminName' => $this->adminName,
                'joinUrl' => $this->joinUrl,
                'linkType' => $this->linkType,
                'isHost' => $this->isHost
            ]);
    }
}
