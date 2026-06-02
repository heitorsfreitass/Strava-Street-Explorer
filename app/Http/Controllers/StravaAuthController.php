<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class StravaAuthController extends Controller
{
    public function redirect()
    {
        $query = http_build_query([
            'client_id' => config('services.strava.client_id'),
            'redirect_uri' => config('services.strava.redirect'),
            'response_type' => 'code',
            'approval_prompt' => 'force',
            'scope' => 'read,activity:read_all',
        ]);

        return redirect(
            "https://www.strava.com/oauth/authorize?{$query}"
        );
    }

    public function callback(Request $request)
    {
        $response = Http::post(
            'https://www.strava.com/oauth/token',
            [
                'client_id' => config('services.strava.client_id'),
                'client_secret' => config('services.strava.client_secret'),
                'code' => $request->code,
                'grant_type' => 'authorization_code',
            ]
        );
        
        $data = $response->json();

        $athlete = $data['athlete'];

        $user = User::updateOrCreate(
            [
                'strava_id' => $athlete['id'],
            ],
            [
                'username' => $athlete['username'] ?? null,
                'name' => trim(
                    ($athlete['firstname'] ?? '') . ' ' . ($athlete['lastname'] ?? '')
                ),
                'first_name' => $athlete['firstname'] ?? null,
                'last_name' => $athlete['lastname'] ?? null,
                'email' => null,
                'profile_picture' => $athlete['profile'] ?? null,
                'strava_access_token' => $data['access_token'],
                'strava_refresh_token' => $data['refresh_token'],
                'strava_token_expires_at' => now()->setTimestamp(
                    $data['expires_at']
                ),
            ]
        );

        Auth::login($user);

        return redirect('/dashboard');
    }
}
