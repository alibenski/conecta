<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class ZoomService
{
    private string $baseUrl = 'https://api.zoom.us/v2';

    private function token(): string
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
     * Append dropdown question to webinar registration safely
     */
    public function appendDropdownToWebinar(int $webinarId, array $question): void
    {
        $token = $this->token();

        // 1️⃣ Get current webinar
        $webinar = Http::withToken($token)
            ->get("{$this->baseUrl}/webinars/{$webinarId}")
            ->throw()
            ->json();

        $existingQuestions = data_get($webinar, 'settings.questions', []);

        // 2️⃣ Prevent duplicate field_name
        foreach ($existingQuestions as $existing) {
            if (($existing['field_name'] ?? null) === $question['field_name']) {
                return; // already exists → idempotent
            }
        }

        // 3️⃣ Merge questions
        $questions = array_merge($existingQuestions, [$question]);

        // 4️⃣ PATCH webinar
        Http::withToken($token)
            ->patch("{$this->baseUrl}/webinars/{$webinarId}", [
                'settings' => [
                    'questions' => $questions,
                ],
            ])
            ->throw();
    }
}
