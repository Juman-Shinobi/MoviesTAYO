<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Movie;
use App\Models\Showtime;
use App\Models\Theater;
use Illuminate\Http\Request;

class ShowtimeAdminController extends Controller
{
    public function index(Request $request)
    {
        $theaters = Theater::orderBy('theater_name')->get();
        $theaterId = $request->query('theater_id');

        $showtimes = Showtime::with(['movie', 'theater'])
            ->when($theaterId, function ($query) use ($theaterId) {
                $query->where('theater_id', $theaterId);
            })
            ->orderBy('show_date')
            ->orderBy('show_time')
            ->get();

        return view('admin.showtimes.index', [
            'showtimes' => $showtimes,
            'theaters' => $theaters,
            'theaterId' => $theaterId,
        ]);
    }

    public function create()
    {
        return view('admin.showtimes.create', [
            'movies' => Movie::orderBy('title')->get(),
            'theaters' => Theater::orderBy('theater_name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'movie_id' => ['required', 'exists:movies,id'],
            'theater_id' => ['required', 'exists:theaters,id'],
            'show_date' => ['required', 'date'],
            'show_time' => ['required'],
        ]);

        $theater = Theater::findOrFail($validated['theater_id']);

        $showtime = Showtime::create([
            'movie_id' => $validated['movie_id'],
            'theater_id' => $validated['theater_id'],
            'show_date' => $validated['show_date'],
            'show_time' => $validated['show_time'],
            'available_seats' => $theater->capacity,
        ]);

        ActivityLog::create([
            'user_id' => $request->user()->id,
            'action' => 'showtime_created',
            'description' => 'Created showtime '.$showtime->id,
            'metadata' => ['showtime_id' => $showtime->id],
        ]);

        return redirect()->route('admin.showtimes.index')->with('status', 'Showtime created.');
    }

    public function edit(Showtime $showtime)
    {
        return view('admin.showtimes.edit', [
            'showtime' => $showtime,
            'movies' => Movie::orderBy('title')->get(),
            'theaters' => Theater::orderBy('theater_name')->get(),
        ]);
    }

    public function update(Request $request, Showtime $showtime)
    {
        $validated = $request->validate([
            'movie_id' => ['required', 'exists:movies,id'],
            'theater_id' => ['required', 'exists:theaters,id'],
            'show_date' => ['required', 'date'],
            'show_time' => ['required'],
            'available_seats' => ['required', 'integer', 'min:0'],
        ]);

        $showtime->update($validated);

        ActivityLog::create([
            'user_id' => $request->user()->id,
            'action' => 'showtime_updated',
            'description' => 'Updated showtime '.$showtime->id,
            'metadata' => ['showtime_id' => $showtime->id],
        ]);

        return redirect()->route('admin.showtimes.index')->with('status', 'Showtime updated.');
    }

    public function destroy(Request $request, Showtime $showtime)
    {
        $id = $showtime->id;
        $showtime->delete();

        ActivityLog::create([
            'user_id' => $request->user()->id,
            'action' => 'showtime_deleted',
            'description' => 'Deleted showtime '.$id,
        ]);

        return redirect()->route('admin.showtimes.index')->with('status', 'Showtime deleted.');
    }
}
