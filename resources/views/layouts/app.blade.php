<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>MoviesTAYO!</title>
        <link rel="icon" href="{{ asset('images/popcorn.png') }}" type="image/png">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Manrope:wght@300;400;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-cinema text-white">
        <div class="flex min-h-screen flex-col">
            @include('partials.nav')

            <main class="mx-auto w-full max-w-6xl flex-1 px-6 pb-16 pt-10">
                {{ $slot }}
            </main>

            <footer class="border-t border-white/10 bg-black/70 py-8">
                <div class="mx-auto flex w-full max-w-6xl flex-col gap-6 px-6 text-sm text-white/70 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-white">MoviesTAYO! Movie Booking</p>
                        <p class="text-white/60">Reserve seats, explore showtimes, and enjoy the show.</p>
                    </div>
                    <div>
                        <p class="text-white/80">Team Members</p>
                        <p class="text-white/60">Krismah Aliyah Francisco • Juman Mama • Kevin Sunga • Andrei Villanueva</p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
