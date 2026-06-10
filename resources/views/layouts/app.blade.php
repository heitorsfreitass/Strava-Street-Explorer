<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Street Explorer' }}</title>

    @vite(['resources/css/app.css'])
</head>
<body>

<div class="app">

    <aside class="sidebar">

        <div class="brand">
            <h1>Street Explorer</h1>
        </div>

        <nav>
            <a href="/dashboard">Dashboard</a>
            <a href="/sync">Sync</a>
        </nav>

    </aside>

    <main class="content">
        {{ $slot ?? '' }}

        @yield('content')
    </main>

</div>

</body>
</html>