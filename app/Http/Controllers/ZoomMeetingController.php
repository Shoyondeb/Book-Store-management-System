<?php

namespace App\Http\Controllers;

use App\Models\ZoomMeeting;
use App\Services\ZoomService;
use App\Mail\MeetingScheduled;
use App\Mail\AdminMeetingNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ZoomMeetingController extends Controller
{
    protected $zoomService;

    public function __construct(ZoomService $zoomService)
    {
        $this->zoomService = $zoomService;
    }

    /**
     * Show meeting scheduling page
     */
    public function create()
    {
        // Get all admins (users with admin role)
        $admins = \App\Models\User::where('role', 'admin')->get(['id', 'name', 'email']);

        return Inertia::render('ZoomMeeting/Create', [
            'admins' => $admins
        ]);
    }

    /**
     * Store a new Zoom meeting
     */
    public function store(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|exists:users,id',
            'topic' => 'required|string|max:255',
            'agenda' => 'nullable|string',
            'start_time' => 'required|date|after:now',
            'duration' => 'required|integer|min:15|max:240',
            'timezone' => 'required|string'
        ]);

        try {
            // Create meeting in Zoom
            $zoomData = $this->zoomService->createMeeting([
                'topic' => $request->topic,
                'agenda' => $request->agenda,
                'start_time' => $request->start_time,
                'duration' => $request->duration,
                'timezone' => $request->timezone
            ]);

            // Get admin user
            $admin = \App\Models\User::find($request->admin_id);

            // Store ALL data - now columns can handle it
            $meeting = ZoomMeeting::create([
                'user_id' => Auth::id(),
                'admin_id' => $request->admin_id,
                'zoom_meeting_id' => $zoomData['id'],
                'topic' => $zoomData['topic'],
                'agenda' => $zoomData['agenda'] ?? $request->agenda,
                'start_time' => $zoomData['start_time'],
                'duration' => $zoomData['duration'],
                'timezone' => $request->timezone,
                'password' => $zoomData['password'],
                'join_url' => $zoomData['join_url'],
                'start_url' => $zoomData['start_url'] ?? null,
                'zoom_response' => $zoomData,
                'status' => 'scheduled'
            ]);
            $meeting->load('admin');

            // DEBUG: Log email details
            \Log::info('=== EMAIL SENDING DEBUG ===');
            \Log::info('Current user ID: ' . Auth::id());
            \Log::info('Current user email: ' . Auth::user()->email);
            \Log::info('Admin ID: ' . $request->admin_id);
            \Log::info('Admin email: ' . ($admin ? $admin->email : 'NOT FOUND'));
            \Log::info('Meeting ID: ' . $meeting->id);

            try {

                // Send email to user (this works)
                Mail::to(Auth::user()->email)->send(new MeetingScheduled($meeting));

                if ($admin && $admin->email) {
                    Mail::to($admin->email)->send(new AdminMeetingNotification($meeting));
                    \Log::info('Admin notification email sent to: ' . $admin->email);
                }
            } catch (\Exception $e) {
                \Log::error('Email error: ' . $e->getMessage());
            }

            return redirect()->route('meetings.show', $meeting->id)
                ->with('success', 'Meeting scheduled successfully!');
        } catch (\Exception $e) {
            \Log::error('Meeting creation failed: ' . $e->getMessage());
            \Log::error('Full error: ' . $e->getTraceAsString());
            return back()->withErrors(['error' => 'Failed to schedule meeting: ' . $e->getMessage()]);
        }
    }

    /**
     * Show meeting details
     */
    public function show(ZoomMeeting $meeting)
    {
        // Authorization check
        if (Auth::id() !== $meeting->user_id && Auth::id() !== $meeting->admin_id) {
            abort(403);
        }

        // Load relationships
        $meeting->load(['user', 'admin']);

        return Inertia::render('ZoomMeeting/Show', [
            'meeting' => [
                'id' => $meeting->id,
                'zoom_meeting_id' => $meeting->zoom_meeting_id,
                'topic' => $meeting->topic,
                'agenda' => $meeting->agenda,
                'start_time' => $meeting->start_time->toIso8601String(),
                'duration' => $meeting->duration,
                'timezone' => $meeting->timezone,
                'password' => $meeting->password,
                'join_url' => $meeting->join_url,
                'start_url' => $meeting->start_url,
                'status' => $meeting->status,
                'user_id' => $meeting->user_id,
                'admin_id' => $meeting->admin_id,
                'admin' => $meeting->admin ? [
                    'id' => $meeting->admin->id,
                    'name' => $meeting->admin->name,
                    'email' => $meeting->admin->email,
                ] : null,
                'user' => $meeting->user ? [
                    'id' => $meeting->user->id,
                    'name' => $meeting->user->name,
                ] : null,
            ]
        ]);
    }

    /**
     * Join meeting page with iframe
     */
    public function join(ZoomMeeting $meeting)
    {
        // Authorization check
        if (Auth::id() !== $meeting->user_id && Auth::id() !== $meeting->admin_id) {
            abort(403);
        }

        // Load admin relationship
        $meeting->load('admin');

        return Inertia::render('ZoomMeeting/Join', [
            'meeting' => [
                'id' => $meeting->id,
                'zoom_meeting_id' => $meeting->zoom_meeting_id,
                'topic' => $meeting->topic,
                'start_time' => $meeting->start_time->toIso8601String(),
                'duration' => $meeting->duration,
                'password' => $meeting->password,
                'join_url' => $meeting->join_url,
                'start_url' => $meeting->start_url,
                'status' => $meeting->status,
                'user_id' => $meeting->user_id,
                'admin_id' => $meeting->admin_id,
                'admin' => $meeting->admin ? [
                    'name' => $meeting->admin->name,
                ] : null,
            ]
        ]);
    }

    /**
     * List user's meetings
     */
    public function index()
    {
        $meetings = ZoomMeeting::where('user_id', Auth::id())
            ->orWhere('admin_id', Auth::id())
            ->with(['user', 'admin'])
            ->latest()
            ->paginate(10)
            ->through(function ($meeting) {
                return [
                    'id' => $meeting->id,
                    'zoom_meeting_id' => $meeting->zoom_meeting_id,
                    'topic' => $meeting->topic,
                    'agenda' => $meeting->agenda,
                    'start_time' => $meeting->start_time->toIso8601String(),
                    'duration' => $meeting->duration,
                    'status' => $meeting->status,
                    'admin' => $meeting->admin ? [
                        'id' => $meeting->admin->id,
                        'name' => $meeting->admin->name,
                        'email' => $meeting->admin->email,
                    ] : null,
                    'user' => $meeting->user ? [
                        'id' => $meeting->user->id,
                        'name' => $meeting->user->name,
                    ] : null,
                ];
            });

        return Inertia::render('ZoomMeeting/Index', [
            'meetings' => $meetings,
        ]);
    }

    /**
     * Cancel a meeting
     */
    public function destroy(ZoomMeeting $meeting)
    {
        // Authorization
        if (Auth::id() !== $meeting->user_id) {
            abort(403);
        }

        try {
            $this->zoomService->deleteMeeting($meeting->zoom_meeting_id);
            $meeting->update(['status' => 'cancelled']);

            return redirect()->route('meetings.index')
                ->with('success', 'Meeting cancelled successfully.');
        } catch (\Exception $e) {
            return redirect()->route('meetings.index')
                ->with('error', 'Failed to cancel meeting.');
        }
    }
}
