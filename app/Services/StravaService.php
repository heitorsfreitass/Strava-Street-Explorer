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
}