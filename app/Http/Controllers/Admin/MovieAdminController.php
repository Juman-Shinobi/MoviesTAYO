<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieAdminController extends Controller
{
    public function index()
    {
        $movies = Movie::orderBy('release_date', 'desc')->get();

        return view('admin.movies.index', [
            'movies' => $movies,
        ]);
    }

    public function create()
    {
        return view('admin.movies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'genre' => ['required', 'string', 'max:255'],
            'rating' => ['nullable', 'string', 'max:50'],
            'duration' => ['required', 'integer', 'min:1'],
            'release_date' => ['required', 'date'],
            'description' => ['required', 'string'],
            'status' => ['required', 'in:now_showing,coming_soon'],
            'poster_image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('poster_image')) {
            $path = $request->file('poster_image')->store('posters', 'public');
            $validated['poster_path'] = 'storage/'.$path;
        }

        $movie = Movie::create($validated);

        ActivityLog::create([
            'user_id' => $request->user()->id,
            'action' => 'movie_created',
            'description' => 'Created movie '.$movie->title,
            'metadata' => ['movie_id' => $movie->id],
        ]);

        return redirect()->route('admin.movies.index')->with('status', 'Movie created.');
    }

    public function edit(Movie $movie)
    {
        return view('admin.movies.edit', [
            'movie' => $movie,
        ]);
    }

    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'genre' => ['required', 'string', 'max:255'],
            'rating' => ['nullable', 'string', 'max:50'],
            'duration' => ['required', 'integer', 'min:1'],
            'release_date' => ['required', 'date'],
            'description' => ['required', 'string'],
            'status' => ['required', 'in:now_showing,coming_soon'],
            'poster_image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('poster_image')) {
            $path = $request->file('poster_image')->store('posters', 'public');
            $validated['poster_path'] = 'storage/'.$path;
        }

        $movie->update($validated);

        ActivityLog::create([
            'user_id' => $request->user()->id,
            'action' => 'movie_updated',
            'description' => 'Updated movie '.$movie->title,
            'metadata' => ['movie_id' => $movie->id],
        ]);

        return redirect()->route('admin.movies.index')->with('status', 'Movie updated.');
    }

    public function destroy(Request $request, Movie $movie)
    {
        $title = $movie->title;
        $movie->delete();

        ActivityLog::create([
            'user_id' => $request->user()->id,
            'action' => 'movie_deleted',
            'description' => 'Deleted movie '.$title,
        ]);

        return redirect()->route('admin.movies.index')->with('status', 'Movie deleted.');
    }
}
