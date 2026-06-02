<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>

    <h1>Olá, {{ auth()->user()->first_name }}</h1>

    <p>Conta conectada ao Strava.</p>

    <img
        src="{{ auth()->user()->profile_picture }}"
        width="150"
        alt=""
    >

    <pre>
ID Strava: {{ auth()->user()->strava_id }}
Username: {{ auth()->user()->username }}
    </pre>

</body>
</html>