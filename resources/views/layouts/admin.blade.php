<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>MoviesTAYO Admin</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Manrope:wght@300;400;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-cinema text-white">
        <div class="flex min-h-screen">
            <aside class="w-64 border-r border-white/10 bg-black/70 px-6 py-8">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="MoviesTAYO logo" class="h-10 w-auto">
                    <div>
                        <p class="font-display text-xl text-orange-400">MoviesTAYO!</p>
                        <p class="text-xs text-white/60 uppercase">{{ auth()->user()->role }}</p>
                    </div>
                </div>

                <nav class="mt-10 space-y-2 text-sm">
                    <a class="{{ request()->routeIs('admin.dashboard') ? 'admin-link-active' : 'admin-link' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <a class="{{ request()->routeIs('admin.movies.*') ? 'admin-link-active' : 'admin-link' }}" href="{{ route('admin.movies.index') }}">Manage Movies</a>
                    <a class="{{ request()->routeIs('admin.theaters.*') ? 'admin-link-active' : 'admin-link' }}" href="{{ route('admin.theaters.index') }}">Manage Theaters</a>
                    <a class="{{ request()->routeIs('admin.showtimes.*') ? 'admin-link-active' : 'admin-link' }}" href="{{ route('admin.showtimes.index') }}">Manage Showtimes</a>
                    <a class="{{ request()->routeIs('admin.seats.*') ? 'admin-link-active' : 'admin-link' }}" href="{{ route('admin.seats.index') }}">Manage Seats</a>
                    <a class="{{ request()->routeIs('admin.bookings.*') ? 'admin-link-active' : 'admin-link' }}" href="{{ route('admin.bookings.index') }}">Reservations</a>

                    @if (auth()->user()->role === 'admin')
                        <a class="{{ request()->routeIs('admin.users.*') ? 'admin-link-active' : 'admin-link' }}" href="{{ route('admin.users.index') }}">Accounts</a>
                        <a class="{{ request()->routeIs('admin.logs.*') ? 'admin-link-active' : 'admin-link' }}" href="{{ route('admin.logs.index') }}">Logs</a>
                    @endif
                </nav>

                <form method="POST" action="{{ route('logout') }}" class="mt-10">
                    @csrf
                    <button class="w-full rounded-full bg-orange-500 px-4 py-2 text-sm font-semibold text-black transition hover:bg-orange-400">
                        Logout
                    </button>
                </form>
            </aside>

            <main class="flex-1 px-10 py-8">
                <div class="mb-6 flex items-center justify-between">
                    <h1 class="text-2xl font-display">{{ $title ?? 'Dashboard' }}</h1>
                    @if (session('status'))
                        <span class="rounded-full bg-emerald-500/20 px-4 py-1 text-xs text-emerald-300">{{ session('status') }}</span>
                    @endif
                </div>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
