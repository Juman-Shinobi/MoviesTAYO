<div class="grid gap-4 sm:grid-cols-2">
    <label class="text-sm">
        Movie
        <select name="movie_id" class="mt-2 w-full rounded-xl bg-white/90 px-4 py-2 text-sm text-slate-900">
            @foreach ($movies as $movie)
                <option value="{{ $movie->id }}" @selected(old('movie_id', $showtime->movie_id ?? '') == $movie->id)>{{ $movie->title }}</option>
            @endforeach
        </select>
    </label>
    <label class="text-sm">
        Theater
        <select name="theater_id" class="mt-2 w-full rounded-xl bg-white/90 px-4 py-2 text-sm text-slate-900">
            @foreach ($theaters as $theater)
                <option value="{{ $theater->id }}" @selected(old('theater_id', $showtime->theater_id ?? '') == $theater->id)>{{ $theater->theater_name }}</option>
            @endforeach
        </select>
    </label>
    <label class="text-sm">
        Show Date
        <input name="show_date" type="date" value="{{ old('show_date', isset($showtime) ? $showtime->show_date->format('Y-m-d') : '') }}" required
            class="mt-2 w-full rounded-xl bg-white/90 px-4 py-2 text-sm text-slate-900">
    </label>
    <label class="text-sm">
        Show Time
        <input name="show_time" type="time" value="{{ old('show_time', $showtime->show_time ?? '') }}" required
            class="mt-2 w-full rounded-xl bg-white/90 px-4 py-2 text-sm text-slate-900">
    </label>
    @if (isset($showtime))
        <label class="text-sm">
            Available Seats
            <input name="available_seats" type="number" min="0" value="{{ old('available_seats', $showtime->available_seats ?? 0) }}" required
                class="mt-2 w-full rounded-xl bg-white/90 px-4 py-2 text-sm text-slate-900">
        </label>
    @endif
</div>
