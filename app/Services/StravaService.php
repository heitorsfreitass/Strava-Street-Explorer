<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;

class StravaService
{
    public function activities(User $user): array
    {
        $response = Http::withToken(
            $user->strava_access_token
        )->get(
            'https://www.strava.com/api/v3/athlete/activities',
            [
                'per_page' => 200,
                'page' => 1,
            ]
        );

        return $response->json();
    }

    public function streams(User $user, int $activityId): array
    {
        $response = Http::withToken(
            $user->strava_access_token
        )->get(
            "https://www.strava.com/api/v3/activities/{$activityId}/streams",
            [
                'keys' => 'latlng,distance',
                'key_by_type' => true,
            ]
        );

        dd(
            $response->status(),
            $response->json()
        );
    }

    public function refreshToken(User $user): void
    {
        $response = Http::post(
            'https://www.strava.com/oauth/token',
            [
                'client_id' => config('services.strava.client_id'),
                'client_secret' => config('services.strava.client_secret'),
                'grant_type' => 'refresh_token',
                'refresh_token' => $user->strava_refresh_token,
            ]
        );

        $data = $response->json();

        $user->update([
            'strava_access_token' => $data['access_token'],
            'strava_refresh_token' => $data['refresh_token'],
            'strava_token_expires_at' => $data['expires_at']
        ]);
    }

    public function ensureValidToken(User $user): void
    {
        if (
            !$user->strava_token_expires_at || $user->strava_token_expires_at <= now()->timestamp
        ) {
            $this->refreshToken($user);

            $user->refresh();
        }
    }
}