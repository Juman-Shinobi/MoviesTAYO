<div class="grid gap-4 sm:grid-cols-2">
    <label class="text-sm">
        Title
        <input name="title" value="{{ old('title', $movie->title ?? '') }}" required
            class="mt-2 w-full rounded-xl bg-white/90 px-4 py-2 text-sm text-slate-900">
    </label>
    <label class="text-sm">
        Genre
        <select name="genre" class="mt-2 w-full rounded-xl bg-white/90 px-4 py-2 text-sm text-slate-900" required>
            @php
                $genres = [
                    'Action', 'Adventure', 'Animation', 'Comedy', 'Crime', 'Documentary',
                    'Drama', 'Family', 'Fantasy', 'Horror', 'Mystery', 'Romance',
                    'Sci-Fi', 'Thriller',
                ];
                $selectedGenre = old('genre', $movie->genre ?? '');
            @endphp
            <option value="">Select Genre</option>
            @foreach ($genres as $genre)
                <option value="{{ $genre }}" @selected($selectedGenre === $genre)>{{ $genre }}</option>
            @endforeach
        </select>
    </label>
    <label class="text-sm">
        Rating
        <select name="rating" class="mt-2 w-full rounded-xl bg-white/90 px-4 py-2 text-sm text-slate-900">
            @php
                $ratings = ['G', 'PG', 'SPG', 'R-13', 'R-16', 'R-18'];
                $selectedRating = old('rating', $movie->rating ?? '');
            @endphp
            <option value="">Select Rating</option>
            @foreach ($ratings as $rating)
                <option value="{{ $rating }}" @selected($selectedRating === $rating)>{{ $rating }}</option>
            @endforeach
        </select>
    </label>
    <label class="text-sm">
        Duration (minutes)
        <input name="duration" type="number" min="1" value="{{ old('duration', $movie->duration ?? '') }}" required
            class="mt-2 w-full rounded-xl bg-white/90 px-4 py-2 text-sm text-slate-900">
    </label>
    <label class="text-sm">
        Release Date
        <input name="release_date" type="date" value="{{ old('release_date', isset($movie) ? $movie->release_date->format('Y-m-d') : '') }}" required
            class="mt-2 w-full rounded-xl bg-white/90 px-4 py-2 text-sm text-slate-900">
    </label>
    <label class="text-sm">
        Status
        <select name="status" class="mt-2 w-full rounded-xl bg-white/90 px-4 py-2 text-sm text-slate-900">
            <option value="now_showing" @selected(old('status', $movie->status ?? '') === 'now_showing')>Now Showing</option>
            <option value="coming_soon" @selected(old('status', $movie->status ?? '') === 'coming_soon')>Coming Soon</option>
        </select>
    </label>
</div>

<label class="mt-4 block text-sm">
    Poster Image
    <input name="poster_image" type="file" accept="image/*"
        class="mt-2 w-full rounded-xl bg-white/90 px-4 py-2 text-sm text-slate-900">
    @if (!empty($movie?->poster_path))
        <p class="mt-2 text-xs text-white/60">Current: {{ $movie->poster_path }}</p>
    @endif
</label>

<label class="mt-4 block text-sm">
    Description
    <textarea name="description" rows="4" required
        class="mt-2 w-full rounded-xl bg-white/90 px-4 py-2 text-sm text-slate-900">{{ old('description', $movie->description ?? '') }}</textarea>
</label>
