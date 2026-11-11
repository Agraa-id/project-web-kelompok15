<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Kelola program prioritas perawatan motor MotoCare.">
    <title>@yield('title', 'Program Prioritas') | MotoCare</title>
    <link rel="stylesheet" href="{{ asset('css/programs.css') }}">
</head>
<body>
    <header class="site-header">
        <a class="brand" href="{{ route('home') }}">Moto<span>Care</span></a>
        <span class="header-label">Workspace Kelompok 15</span>
    </header>

    <main class="page">
        @yield('content')
    </main>
</body>
</html>
