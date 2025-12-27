<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Showtime;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->trim();

        $movies = Movie::query()
            ->when($search->isNotEmpty(), function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('genre', 'like', "%{$search}%");
            })
            ->orderBy('release_date', 'desc')
            ->get()
            ->groupBy('status');

        return view('movies.index', [
            'nowShowing' => $movies->get('now_showing', collect()),
            'comingSoon' => $movies->get('coming_soon', collect()),
            'search' => $search,
        ]);
    }

    public function show(Movie $movie)
    {
        $showtimes = Showtime::with('theater')
            ->where('movie_id', $movie->id)
            ->orderBy('show_date')
            ->orderBy('show_time')
            ->get();

        $theaters = $showtimes->groupBy('theater_id')->map(function ($items) {
            return [
                'theater' => $items->first()->theater,
                'dates' => $items->groupBy('show_date')->map(function ($dateItems) {
                    return $dateItems->values();
                }),
            ];
        });

        $showtimesPayload = $showtimes->map(function ($showtime) {
            return [
                'id' => $showtime->id,
                'theater_id' => $showtime->theater_id,
                'date' => $showtime->show_date->format('Y-m-d'),
                'time' => $showtime->show_time,
            ];
        })->values();

        return view('movies.show', [
            'movie' => $movie,
            'theaters' => $theaters,
            'showtimes' => $showtimes,
            'showtimesPayload' => $showtimesPayload,
        ]);
    }
}
