<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingAdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->trim();

        $bookings = Booking::with(['movie', 'showtime', 'user', 'seats'])
            ->when($search->isNotEmpty(), function ($query) use ($search) {
                $value = $search->toString();
                $query->where('booking_code', 'like', "%{$value}%")
                    ->orWhereHas('user', function ($userQuery) use ($value) {
                        $userQuery->where('email', 'like', "%{$value}%")
                            ->orWhere('name', 'like', "%{$value}%");
                    })
                    ->orWhereHas('movie', function ($movieQuery) use ($value) {
                        $movieQuery->where('title', 'like', "%{$value}%");
                    });
            })
            ->orderByDesc('booking_date')
            ->paginate(10)
            ->withQueryString();

        return view('admin.bookings.index', [
            'bookings' => $bookings,
            'search' => $search,
        ]);
    }

    public function approve(Request $request, Booking $booking)
    {
        if ($booking->status === 'approved') {
            return redirect()->route('admin.bookings.index')->with('status', 'Booking already approved.');
        }

        if ($booking->showtime->available_seats < $booking->num_tickets) {
            return redirect()->route('admin.bookings.index')->with('status', 'Not enough available seats.');
        }

        DB::transaction(function () use ($request, $booking) {
            $booking->update(['status' => 'approved']);

            $booking->seats()->update(['seat_status' => 'booked']);
            $booking->showtime()->decrement('available_seats', $booking->num_tickets);

            ActivityLog::create([
                'user_id' => $request->user()->id,
                'action' => 'booking_approved',
                'description' => 'Approved booking '.$booking->booking_code,
                'metadata' => ['booking_id' => $booking->id],
            ]);
        });

        return redirect()->route('admin.bookings.index')->with('status', 'Booking approved.');
    }
}
