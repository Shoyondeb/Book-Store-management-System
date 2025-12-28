<?php
// app/Http/Controllers/MeetingController.php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\User;
use App\Services\ZoomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MeetingScheduled;
use Inertia\Inertia;

class MeetingController extends Controller
{
    private $zoomService;

    public function __construct(ZoomService $zoomService)
    {
        $this->zoomService = $zoomService;
    }

    public function create()
    {
        $hosts = User::getMeetingHosts()->map(function ($host) {
            return [
                'id' => $host->id,
                'name' => $host->name,
                'email' => $host->email,
                'role' => $host->role
            ];
        });

        return Inertia::render('Meetings/Create', [
            'hosts' => $hosts
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'host_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'scheduled_date' => 'required|date|after:today',
            'scheduled_time' => 'required',
            'duration' => 'required|integer|min:15|max:120',
            'meeting_type' => 'required|string'
        ]);

        // Check if host can host meetings
        $host = User::findOrFail($request->host_id);
        if (!$host->canHostMeetings()) {
            return back()->withErrors(['host_id' => 'Selected host cannot accept meetings.']);
        }

        // Create meeting record
        $meeting = Meeting::create([
            'user_id' => auth()->id(),
            'host_id' => $request->host_id,
            'title' => $request->title,
            'description' => $request->description,
            'scheduled_date' => $request->scheduled_date,
            'scheduled_time' => $request->scheduled_time,
            'duration' => $request->duration,
            'timezone' => config('app.timezone'),
            'meeting_type' => $request->meeting_type,
            'status' => 'scheduled'
        ]);

        // Create Zoom meeting
        $startTime = \Carbon\Carbon::parse($meeting->scheduled_date->format('Y-m-d') . ' ' . $meeting->scheduled_time)
            ->setTimezone($meeting->timezone)
            ->format('Y-m-d\TH:i:s\Z');

        $zoomMeetingData = [
            'topic' => $meeting->title,
            'start_time' => $startTime,
            'duration' => $meeting->duration,
            'timezone' => $meeting->timezone
        ];

        try {
            $zoomMeeting = $this->zoomService->createMeeting($zoomMeetingData);

            // Get embed URL for the meeting
            $embedUrl = $this->getZoomEmbedUrl($zoomMeeting['join_url']);

            $meeting->update([
                'zoom_meeting_id' => $zoomMeeting['id'],
                'zoom_join_url' => $zoomMeeting['join_url'],
                'zoom_start_url' => $zoomMeeting['start_url'] ?? null,
                'zoom_password' => $zoomMeeting['password'],
                'zoom_embed_url' => $embedUrl,
            ]);

            // Send emails to both parties
            Mail::to($meeting->user->email)->send(new MeetingScheduled($meeting, 'customer'));
            Mail::to($meeting->host->email)->send(new MeetingScheduled($meeting, 'host'));

            return redirect()->route('meetings.my-meetings')
                ->with('success', 'Meeting scheduled successfully! Check your email for details.')
                ->with('zoom_join_url', $meeting->zoom_join_url)
                ->with('zoom_embed_url', $embedUrl)
                ->with('zoom_password', $meeting->zoom_password);
        } catch (\Exception $e) {
            // If Zoom creation fails, delete the meeting record
            $meeting->delete();

            \Log::error('Zoom meeting creation failed', [
                'error' => $e->getMessage(),
                'meeting_data' => $zoomMeetingData
            ]);

            return back()->with('error', 'Failed to create Zoom meeting: ' . $e->getMessage());
        }
    }

    public function myMeetings()
    {
        $meetings = Meeting::where('user_id', auth()->id())
            ->orWhere('host_id', auth()->id())
            ->with(['user', 'host', 'book'])
            ->orderBy('scheduled_date', 'desc')
            ->orderBy('scheduled_time', 'desc')
            ->get()
            ->map(function ($meeting) {
                return [
                    'id' => $meeting->id,
                    'title' => $meeting->title,
                    'description' => $meeting->description,
                    'scheduled_date' => $meeting->scheduled_date->format('Y-m-d'),
                    'scheduled_time' => $meeting->scheduled_time,
                    'duration' => $meeting->duration,
                    'status' => $meeting->status,
                    'zoom_meeting_id' => $meeting->zoom_meeting_id,
                    'zoom_join_url' => $meeting->zoom_join_url,
                    'zoom_embed_url' => $meeting->zoom_embed_url,
                    'zoom_password' => $meeting->zoom_password,
                    'can_join' => $meeting->canJoin(),
                    'is_upcoming' => $meeting->isUpcoming(),
                    'user' => [
                        'id' => $meeting->user->id,
                        'name' => $meeting->user->name,
                        'email' => $meeting->user->email
                    ],
                    'host' => [
                        'id' => $meeting->host->id,
                        'name' => $meeting->host->name,
                        'email' => $meeting->host->email
                    ],
                    'book' => $meeting->book ? [
                        'title' => $meeting->book->title,
                        'cover_url' => $meeting->book->cover_url
                    ] : null
                ];
            });

        return Inertia::render('Meetings/MyMeetings', [
            'meetings' => $meetings
        ]);
    }

    public function join(Meeting $meeting)
    {
        // Check if user is authorized to join this meeting
        if ($meeting->user_id !== auth()->id() && $meeting->host_id !== auth()->id()) {
            abort(403);
        }

        if (!$meeting->canJoin()) {
            return redirect()->route('meetings.my-meetings')
                ->with('error', 'Meeting is not available to join at this time.');
        }

        // Use embed URL if available, otherwise convert join URL to embed URL
        $embedUrl = $meeting->zoom_embed_url ?? $this->getZoomEmbedUrl($meeting->zoom_join_url);

        $meetingData = [
            'id' => $meeting->id,
            'title' => $meeting->title,
            'zoom_meeting_id' => $meeting->zoom_meeting_id,
            'zoom_join_url' => $meeting->zoom_join_url,
            'zoom_embed_url' => $embedUrl,
            'zoom_password' => $meeting->zoom_password,
            'user' => [
                'name' => $meeting->user->name,
                'is_current_user' => $meeting->user_id === auth()->id()
            ],
            'host' => [
                'name' => $meeting->host->name,
                'is_current_user' => $meeting->host_id === auth()->id()
            ]
        ];

        return Inertia::render('Meetings/Join', [
            'meeting' => $meetingData
        ]);
    }

    public function destroy(Meeting $meeting)
    {
        // Check authorization
        if ($meeting->user_id !== auth()->id() && $meeting->host_id !== auth()->id()) {
            abort(403);
        }

        // Delete from Zoom (only if it's a real meeting, not mock)
        if ($meeting->zoom_meeting_id && !str_starts_with($meeting->zoom_meeting_id, 'mock_')) {
            try {
                $this->zoomService->deleteMeeting($meeting->zoom_meeting_id);
            } catch (\Exception $e) {
                \Log::error('Failed to delete Zoom meeting', [
                    'meeting_id' => $meeting->id,
                    'zoom_meeting_id' => $meeting->zoom_meeting_id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $meeting->delete();

        return redirect()->route('meetings.my-meetings')
            ->with('success', 'Meeting cancelled successfully.');
    }

    /**
     * Convert Zoom join URL to embed URL
     */
    private function getZoomEmbedUrl($joinUrl)
    {
        if (!$joinUrl) {
            return null;
        }

        // If it's already an embed URL, return as is
        if (str_contains($joinUrl, '/wc/join/')) {
            return $joinUrl;
        }

        // Convert regular Zoom URL to embed URL
        // Format: https://us04web.zoom.us/j/74227638821 → https://us04web.zoom.us/wc/join/74227638821
        if (preg_match('/https:\/\/([^\/]+)\/j\/(\d+)/', $joinUrl, $matches)) {
            return "https://{$matches[1]}/wc/join/{$matches[2]}";
        }

        // For mock/test URLs
        if (str_contains($joinUrl, '/test/mock-meeting')) {
            return 'https://zoom.us/test/meeting';
        }

        return $joinUrl;
    }
}
