<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ZoomService
{
    private $clientId;
    private $clientSecret;
    private $accountId;
    private $baseUrl = 'https://api.zoom.us/v2';

    public function __construct()
    {
        $this->clientId = config('zoom.client_id');
        $this->clientSecret = config('zoom.client_secret');
        $this->accountId = config('zoom.account_id');
    }

    /**
     * Generate Server-to-Server OAuth Token
     */
    private function getAccessToken()
    {
        return Cache::remember('zoom_access_token', 3500, function () {
            $response = Http::withBasicAuth($this->clientId, $this->clientSecret)
                ->asForm()
                ->post('https://zoom.us/oauth/token', [
                    'grant_type' => 'account_credentials',
                    'account_id' => $this->accountId
                ]);

            if ($response->failed()) {
                Log::error('Zoom token error', $response->json());
                throw new \Exception('Failed to get Zoom access token: ' . $response->body());
            }

            return $response->json()['access_token'];
        });
    }

    /**
     * Create a Zoom meeting
     */
    public function createMeeting(array $data)
    {
        $accessToken = $this->getAccessToken();

        $response = Http::withToken($accessToken)
            ->post("{$this->baseUrl}/users/me/meetings", [
                'topic' => $data['topic'],
                'type' => 2, // Scheduled meeting
                'start_time' => $this->formatDateTime($data['start_time']),
                'duration' => $data['duration'],
                'timezone' => $data['timezone'] ?? 'UTC',
                'agenda' => $data['agenda'] ?? null,
                'settings' => [
                    'host_video' => true,
                    'participant_video' => true,
                    'join_before_host' => false,
                    'mute_upon_entry' => false,
                    'waiting_room' => true,
                    'auto_recording' => 'none',
                    'encryption_type' => 'enhanced_encryption',
                    'approved_or_denied_countries_or_regions' => [
                        'enable' => false
                    ]
                ]
            ]);

        if ($response->failed()) {
            Log::error('Zoom create meeting error', $response->json());
            throw new \Exception('Failed to create Zoom meeting: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Get meeting details
     */
    public function getMeeting($meetingId)
    {
        $accessToken = $this->getAccessToken();

        $response = Http::withToken($accessToken)
            ->get("{$this->baseUrl}/meetings/{$meetingId}");

        return $response->json();
    }

    /**
     * Delete a meeting
     */
    public function deleteMeeting($meetingId)
    {
        $accessToken = $this->getAccessToken();

        $response = Http::withToken($accessToken)
            ->delete("{$this->baseUrl}/meetings/{$meetingId}");

        return $response->successful();
    }

    /**
     * Format datetime for Zoom API
     */
    private function formatDateTime($dateTime)
    {
        if ($dateTime instanceof \DateTime) {
            return $dateTime->format('Y-m-d\TH:i:s');
        }

        return \Carbon\Carbon::parse($dateTime)->format('Y-m-d\TH:i:s');
    }
}
