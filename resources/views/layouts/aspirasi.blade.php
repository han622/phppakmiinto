<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Aspirasi Kampus')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="/">Aspirasi Kampus</a>
        <ul class="navbar-nav me-auto">
            @auth
                @if (auth()->user()->role === 'mahasiswa')
                    <li class="nav-item"><a class="nav-link" href="{{ route('tiket.index') }}">Tiket Saya</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('tiket.create') }}">Buat Tiket</a></li>
                @endif
                @if (auth()->user()->role === 'staff')
                <li class="nav-item"><a class="nav-link" href="{{ route('staff.dashboard') }}">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('staff.tiket.index') }}">Semua Tiket</a></li>
            @endif
            @endauth
            <li class="nav-item"><a class="nav-link" href="{{ route('lacak') }}">Lacak Tiket</a></li>
        </ul>
        @auth
            <form method="POST" action="{{ route('logout') }}" class="d-flex align-items-center gap-2 m-0">
                @csrf
                <span class="text-white small">{{ auth()->user()->username }} ({{ auth()->user()->role }})</span>
                <button class="btn btn-sm btn-light">Keluar</button>
            </form>
        @endauth
    </div>
</nav>
<div class="container">
    @yield('content')
</div>
</body>
</html>