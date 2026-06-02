<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StravaAuthController;
use App\Http\Controllers\StravaSyncController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

Route::get('/sync', [StravaSyncController::class, 'sync'])->middleware('auth');

Route::get('/test-stream', [StravaSyncController::class, 'testStream']);

Route::get('/auth/strava', [StravaAuthController::class, 'redirect']);
Route::get('/auth/strava/callback', [StravaAuthController::class, 'callback']);

Route::get('/activity/{id}', function ($id) {

    $user = auth()->user();

    $response = \Illuminate\Support\Facades\Http::withToken(
        $user->strava_access_token
    )->get(
        "https://www.strava.com/api/v3/activities/{$id}"
    );

    dd($response->json());

});