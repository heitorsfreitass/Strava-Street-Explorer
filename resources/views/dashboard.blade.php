@extends('layouts.app')

@section('content')

<div class="hero">

    <div>

        <span class="badge">
            Connected to Strava
        </span>

        <h1>
            Welcome back,
            {{ auth()->user()->first_name }}
        </h1>

        <p>
            Explore every street. Track every route.
        </p>

    </div>

    <img
        class="avatar"
        src="{{ auth()->user()->profile_picture }}"
        alt=""
    >

</div>

<div class="stats">

    <div class="card">
        <span>Activities</span>
        <h2>{{ \App\Models\Activity::count() }}</h2>
    </div>

    <div class="card">
        <span>Total Distance</span>
        <h2>
            {{
                round(
                    \App\Models\Activity::sum('distance') / 1000,
                    1
                )
            }}
            km
        </h2>
    </div>

    <div class="card">
        <span>Total Time</span>
        <h2>
            {{
                round(
                    \App\Models\Activity::sum('moving_time') / 3600,
                    1
                )
            }}
            h
        </h2>
    </div>

</div>

<div class="panel">

    <div class="panel-header">
        Recent Activities
    </div>

    <table>

        <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Distance</th>
            <th>Date</th>
        </tr>
        </thead>

        <tbody>

        @foreach(
            \App\Models\Activity::latest()
                ->take(10)
                ->get()
            as $activity
        )

            <tr>

                <td>{{ $activity->name }}</td>

                <td>{{ $activity->sport_type }}</td>

                <td>
                    {{
                        round(
                            $activity->distance / 1000,
                            2
                        )
                    }} km
                </td>

                <td>
                    {{ $activity->started_at }}
                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

@endsection