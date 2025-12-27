<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Seat;
use App\Models\Theater;
use Illuminate\Http\Request;

class TheaterAdminController extends Controller
{
    public function index()
    {
        $theaters = Theater::orderBy('theater_name')->get();

        return view('admin.theaters.index', [
            'theaters' => $theaters,
        ]);
    }

    public function create()
    {
        return view('admin.theaters.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'theater_name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:1'],
        ]);

        $theater = Theater::create($validated);

        $this->generateSeats($theater);

        ActivityLog::create([
            'user_id' => $request->user()->id,
            'action' => 'theater_created',
            'description' => 'Created theater '.$theater->theater_name,
            'metadata' => ['theater_id' => $theater->id],
        ]);

        return redirect()->route('admin.theaters.index')->with('status', 'Theater created.');
    }

    private function generateSeats(Theater $theater): void
    {
        $perRow = 10;
        $totalSeats = $theater->capacity;
        $rows = (int) ceil($totalSeats / $perRow);
        $seatCount = 0;

        for ($row = 0; $row < $rows; $row++) {
            $rowLabel = chr(65 + $row);
            for ($col = 1; $col <= $perRow; $col++) {
                $seatCount++;
                if ($seatCount > $totalSeats) {
                    break 2;
                }

                Seat::create([
                    'theater_id' => $theater->id,
                    'seat_number' => $rowLabel.$col,
                    'seat_status' => 'available',
                ]);
            }
        }
    }

    public function edit(Theater $theater)
    {
        return view('admin.theaters.edit', [
            'theater' => $theater,
        ]);
    }

    public function update(Request $request, Theater $theater)
    {
        $validated = $request->validate([
            'theater_name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:1'],
        ]);

        $theater->update($validated);

        ActivityLog::create([
            'user_id' => $request->user()->id,
            'action' => 'theater_updated',
            'description' => 'Updated theater '.$theater->theater_name,
            'metadata' => ['theater_id' => $theater->id],
        ]);

        return redirect()->route('admin.theaters.index')->with('status', 'Theater updated.');
    }

    public function destroy(Request $request, Theater $theater)
    {
        $name = $theater->theater_name;
        $theater->delete();

        ActivityLog::create([
            'user_id' => $request->user()->id,
            'action' => 'theater_deleted',
            'description' => 'Deleted theater '.$name,
        ]);

        return redirect()->route('admin.theaters.index')->with('status', 'Theater deleted.');
    }
}
