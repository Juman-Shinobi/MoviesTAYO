@php
    $isMovies = request()->routeIs('movies.*');
    $isTheaters = request()->routeIs('theaters.*');
    $isReservations = request()->routeIs('reservations.*');
@endphp

<nav class="border-b border-white/5 bg-black/60 backdrop-blur">
    <div class="mx-auto flex w-full max-w-6xl flex-wrap items-center justify-between gap-4 px-6 py-4">
        <div class="flex items-center">
            <img src="{{ asset('images/logo-large.png') }}" alt="MoviesTAYO logo" class="h-16 w-auto">
        </div>

        <form method="GET" class="flex flex-1 min-w-[220px] max-w-md items-center gap-2 rounded-full border border-orange-500/70 bg-black/60 px-4 py-2">
            <input
                name="search"
                type="text"
                value="{{ request('search') }}"
                placeholder="Search Movie or Theater"
                class="w-full appearance-none border-0 bg-transparent text-sm text-white placeholder:text-white/60 outline-none shadow-none focus:border-0 focus:outline-none focus:ring-0 focus:ring-transparent"
            >
            <button type="submit" class="rounded-full bg-orange-500 px-2 py-2 text-black transition hover:bg-orange-400">
                <img src="{{ asset('images/search-large.png') }}" alt="Search" class="h-5 w-7">
            </button>
        </form>

        <div class="flex items-center gap-6 text-sm font-semibold">
            <a class="{{ $isMovies ? 'nav-active' : 'nav-link' }}" href="{{ route('movies.index') }}">
                <img src="{{ asset('images/movies_navbar.png') }}" alt="" class="h-5 w-auto">
                Movies
            </a>
            <a class="{{ $isTheaters ? 'nav-active' : 'nav-link' }}" href="{{ route('theaters.index') }}">
                <img src="{{ asset('images/theaters_navbar.png') }}" alt="" class="h-5 w-auto">
                Theaters
            </a>
            <a class="{{ $isReservations ? 'nav-active' : 'nav-link' }}" href="{{ route('reservations.index') }}">
                <img src="{{ asset('images/reservations_navbar.png') }}" alt="" class="h-5 w-auto">
                Reservations
            </a>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="rounded-full bg-orange-500 px-5 py-2 text-sm font-semibold text-black transition hover:bg-orange-400">
                Logout
            </button>
        </form>
    </div>
</nav>
