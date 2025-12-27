<x-admin-layout :title="'Reservations'">
    <div class="mb-6 flex flex-wrap items-center gap-4">
        <form method="GET" class="flex flex-1 items-center gap-2">
            <input
                name="search"
                type="text"
                value="{{ $search }}"
                placeholder="Search booking, user, or movie"
                class="w-full max-w-md rounded-full bg-white/90 px-4 py-2 text-sm text-slate-900"
            >
            <button class="rounded-full border border-white/30 px-4 py-2 text-xs font-semibold text-white/80 hover:text-white">
                Search
            </button>
        </form>
    </div>

    <div class="overflow-hidden rounded-2xl bg-black/60 shadow-glow">
        <table class="w-full text-left text-sm">
            <thead class="bg-white/5 text-xs uppercase text-white/60">
                <tr>
                    <th class="px-4 py-3">Booking</th>
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Movie</th>
                    <th class="px-4 py-3">Showtime</th>
                    <th class="px-4 py-3">Seats</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                    <tr class="border-t border-white/10">
                        <td class="px-4 py-3">{{ $booking->booking_code }}</td>
                        <td class="px-4 py-3">{{ $booking->user->email }}</td>
                        <td class="px-4 py-3">{{ $booking->movie->title }}</td>
                        <td class="px-4 py-3">
                            {{ $booking->showtime->show_date->format('M d, Y') }} {{ $booking->showtime->show_time }}
                        </td>
                        <td class="px-4 py-3">{{ $booking->seats->pluck('seat_number')->implode(', ') }}</td>
                        <td class="px-4 py-3">{{ ucfirst($booking->status) }}</td>
                        <td class="px-4 py-3">
                            @if ($booking->status !== 'approved')
                                <form method="POST" action="{{ route('admin.bookings.approve', $booking) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="rounded-full bg-emerald-500 px-3 py-1 text-xs font-semibold text-black">Approve</button>
                                </form>
                            @else
                                <span class="text-emerald-400">Approved</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $bookings->links() }}
    </div>
</x-admin-layout>
