<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Carbon\Carbon;
use App\Services\StravaService;

class StravaSyncController extends Controller
{
    public function sync(StravaService $strava)
    {
        $user = auth()->user();

        $activities = $strava->activities($user);

        foreach ($activities as $activity) {
            Activity::updateOrCreate(
                [
                    'strava_id' => $activity['id'],
                ],
                [
                    'user_id' => $user->id,
                    'name' => $activity['name'],
                    'sport_type' => $activity['sport_type'],
                    'distance' => $activity['distance'],
                    'moving_time' => $activity['moving_time'],
                    'started_at' => Carbon::parse($activity['start_date']),
                ]
            );
        }

        return [
            'imported' => count($activities),
        ];
    }

    public function testStream(
        StravaService $strava
    ) {

        $activity = Activity::first();

        $stream = $strava->streams(
            auth()->user(),
            $activity->strava_id
        );

        dd([
            'name' => $activity->name,
            'sport_type' => $activity->sport_type,
            'strava_id' => $activity->strava_id,
        ]);
    }
}
