<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Seat;
use App\Models\Theater;
use Illuminate\Http\Request;

class SeatAdminController extends Controller
{
    public function index(Request $request)
    {
        $theaters = Theater::orderBy('theater_name')->get();
        $theaterId = $request->query('theater_id');

        $seats = Seat::with('theater')
            ->when($theaterId, function ($query) use ($theaterId) {
                $query->where('theater_id', $theaterId);
            })
            ->orderBy('theater_id')
            ->orderBy('seat_number')
            ->get();

        return view('admin.seats.index', [
            'seats' => $seats,
            'theaters' => $theaters,
            'theaterId' => $theaterId,
        ]);
    }

    public function create()
    {
        return view('admin.seats.create', [
            'theaters' => Theater::orderBy('theater_name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'theater_id' => ['required', 'exists:theaters,id'],
            'seat_number' => ['required', 'string', 'max:20'],
            'seat_status' => ['required', 'in:available,reserved,booked'],
        ]);

        $seat = Seat::create($validated);

        ActivityLog::create([
            'user_id' => $request->user()->id,
            'action' => 'seat_created',
            'description' => 'Created seat '.$seat->seat_number,
            'metadata' => ['seat_id' => $seat->id],
        ]);

        return redirect()->route('admin.seats.index')->with('status', 'Seat created.');
    }

    public function edit(Seat $seat)
    {
        return view('admin.seats.edit', [
            'seat' => $seat,
            'theaters' => Theater::orderBy('theater_name')->get(),
        ]);
    }

    public function update(Request $request, Seat $seat)
    {
        $validated = $request->validate([
            'theater_id' => ['required', 'exists:theaters,id'],
            'seat_number' => ['required', 'string', 'max:20'],
            'seat_status' => ['required', 'in:available,reserved,booked'],
        ]);

        $seat->update($validated);

        ActivityLog::create([
            'user_id' => $request->user()->id,
            'action' => 'seat_updated',
            'description' => 'Updated seat '.$seat->seat_number,
            'metadata' => ['seat_id' => $seat->id],
        ]);

        return redirect()->route('admin.seats.index')->with('status', 'Seat updated.');
    }

    public function destroy(Request $request, Seat $seat)
    {
        $label = $seat->seat_number;
        $seat->delete();

        ActivityLog::create([
            'user_id' => $request->user()->id,
            'action' => 'seat_deleted',
            'description' => 'Deleted seat '.$label,
        ]);

        return redirect()->route('admin.seats.index')->with('status', 'Seat deleted.');
    }
}
