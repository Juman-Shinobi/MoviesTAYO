<x-app-layout>
    <div class="mx-auto max-w-3xl rounded-3xl bg-black/60 p-10 text-center shadow-glow">
        <div class="flex flex-col items-center gap-4">
            <img src="{{ asset('images/logo-large.png') }}" alt="MoviesTAYO logo" class="h-24 w-auto">
            <h1 class="text-2xl font-display text-emerald-400">
                Successfully Booked! Please wait for our employee to approve your reservation.
            </h1>
        </div>

        <div class="mt-8 space-y-2 text-sm text-white/80">
            <p>Movie Name: {{ $booking->movie->title }}</p>
            <p>Booking ID: {{ $booking->booking_code }}</p>
            <p>Showtime date: {{ $booking->showtime->show_date->format('F d, Y') }}</p>
            <p>Time: {{ $booking->showtime->show_time }}</p>
        </div>

        <p class="mt-6 text-sm">
            Click <a href="{{ route('reservations.index') }}" class="text-blue-400 hover:text-blue-300">here</a> to redirect to the Reservations page
        </p>
    </div>
</x-app-layout>
