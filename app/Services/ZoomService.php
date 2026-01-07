<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class ZoomService
{
    private string $baseUrl = 'https://api.zoom.us/v2';

    private function accessToken(): string
    {
        $response = Http::withBasicAuth(
            config('services.zoom.client_id'),
            config('services.zoom.client_secret')
        )->asForm()->post('https://zoom.us/oauth/token', [
            'grant_type' => 'account_credentials',
            'account_id' => config('services.zoom.account_id'),
        ]);

        if (! $response->ok()) {
            throw new RuntimeException(
                'Zoom OAuth failed: ' . $response->body()
            );
        }

        return $response->json('access_token');
    }

    /**
     * Adds a dropdown (single-choice) question to a webinar registration form
     */
    public function addDropdownToWebinar(int $webinarId, array $question): void
    {
        Http::withToken($this->accessToken())
            ->patch("{$this->baseUrl}/webinars/{$webinarId}", [
                'settings' => [
                    'registration_type' => 1,
                    'questions' => [$question],
                ],
            ])
            ->throw();
    }
}
