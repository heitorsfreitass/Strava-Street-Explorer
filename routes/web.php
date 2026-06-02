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

Route::get('/auth/strava', [StravaAuthController::class, 'redirect']);
Route::get('/auth/strava/callback', [StravaAuthController::class, 'callback']);
