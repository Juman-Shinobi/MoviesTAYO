<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Booking;
use App\Models\Seat;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $bookings = Booking::with(['movie', 'showtime.theater', 'seats'])
            ->where('user_id', $request->user()->id)
            ->orderByDesc('booking_date')
            ->get();

        return view('reservations.index', [
            'bookings' => $bookings,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'showtime_id' => ['required', 'exists:showtimes,id'],
            'seats' => ['required', 'array', 'min:1'],
            'seats.*' => ['required', 'exists:seats,id'],
        ]);

        $showtime = Showtime::with('movie')->findOrFail($validated['showtime_id']);
        $seatIds = collect($validated['seats'])->map(fn ($id) => (int) $id)->unique()->values();

        $validSeatIds = Seat::where('theater_id', $showtime->theater_id)
            ->whereIn('id', $seatIds)
            ->pluck('id');

        if ($validSeatIds->count() !== $seatIds->count()) {
            return back()->withErrors(['seats' => 'One or more selected seats are invalid.'])->withInput();
        }

        $alreadyBooked = Booking::query()
            ->where('showtime_id', $showtime->id)
            ->where('status', 'approved')
            ->whereHas('seats', function ($query) use ($seatIds) {
                $query->whereIn('seats.id', $seatIds);
            })
            ->exists();

        if ($alreadyBooked) {
            return back()->withErrors(['seats' => 'One or more selected seats are already reserved.'])->withInput();
        }

        $booking = DB::transaction(function () use ($request, $showtime, $seatIds) {
            $booking = Booking::create([
                'showtime_id' => $showtime->id,
                'user_id' => $request->user()->id,
                'booking_date' => now()->toDateString(),
                'num_tickets' => $seatIds->count(),
                'movie_id' => $showtime->movie_id,
                'seat_id' => $seatIds->first(),
                'booking_code' => strtoupper(Str::random(10)),
                'status' => 'pending',
            ]);

            $booking->seats()->sync($seatIds);

            ActivityLog::create([
                'user_id' => $request->user()->id,
                'action' => 'booking_created',
                'description' => 'Created booking '.$booking->booking_code,
                'metadata' => [
                    'booking_id' => $booking->id,
                    'showtime_id' => $showtime->id,
                    'seat_ids' => $seatIds,
                ],
            ]);

            return $booking;
        });

        return redirect()->route('reservations.success', $booking);
    }

    public function success(Booking $booking)
    {
        if ($booking->user_id !== request()->user()->id) {
            abort(403);
        }

        $booking->load(['movie', 'showtime', 'seats']);

        return view('reservations.success', [
            'booking' => $booking,
        ]);
    }

    public function seats(Showtime $showtime)
    {
        $bookedSeatIds = Booking::query()
            ->where('showtime_id', $showtime->id)
            ->where('status', 'approved')
            ->with('seats:id')
            ->get()
            ->pluck('seats')
            ->flatten()
            ->pluck('id')
            ->unique()
            ->values();

        $seats = Seat::query()
            ->where('theater_id', $showtime->theater_id)
            ->orderBy('seat_number')
            ->get()
            ->map(function ($seat) use ($bookedSeatIds) {
                return [
                    'id' => $seat->id,
                    'seat_number' => $seat->seat_number,
                    'seat_status' => $bookedSeatIds->contains($seat->id) ? 'reserved' : 'available',
                ];
            });

        return response()->json([
            'showtime_id' => $showtime->id,
            'seats' => $seats,
        ]);
    }
}
