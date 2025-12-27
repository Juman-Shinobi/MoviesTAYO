<x-app-layout>
    <div class="space-y-6">
        <h1 class="text-2xl font-display">Your Reservations</h1>

        <div class="space-y-6">
            @forelse ($bookings as $booking)
                <div class="rounded-3xl border border-white/20 bg-black/60 p-6 shadow-glow">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="space-y-2 text-sm text-white/80">
                            <p class="text-base font-semibold text-white">Movie Name: {{ $booking->movie->title }}</p>
                            <p>Booking ID: {{ $booking->booking_code }}</p>
                            <p>Theater: {{ $booking->showtime->theater->theater_name }}</p>
                            <p>Showtime date: {{ $booking->showtime->show_date->format('F d, Y') }}</p>
                            <p>Time: {{ $booking->showtime->show_time }}</p>
                            <p>Seats: {{ $booking->seats->pluck('seat_number')->implode(', ') }}</p>
                        </div>
                        <span class="flex items-center gap-2 text-sm font-semibold {{ $booking->status === 'approved' ? 'text-emerald-400' : 'text-yellow-400' }}">
                            <span class="h-2 w-2 rounded-full {{ $booking->status === 'approved' ? 'bg-emerald-400' : 'bg-yellow-400' }}"></span>
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-white/60">No reservations yet.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
