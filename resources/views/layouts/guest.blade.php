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
        <main class="flex min-h-screen items-center justify-center px-6 py-12">
            <div class="w-full max-w-md">
                <div class="mb-6 flex flex-col items-center gap-3">
                    <img src="{{ asset('images/logo-large.png') }}" alt="MoviesTAYO logo" class="h-28 w-auto">
                </div>
                <div class="rounded-[28px] bg-white/95 px-8 py-7 text-slate-900 shadow-glow">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </body>
</html>
