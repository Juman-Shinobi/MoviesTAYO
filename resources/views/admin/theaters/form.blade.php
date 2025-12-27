<div class="grid gap-4 sm:grid-cols-2">
    <label class="text-sm">
        Theater Name
        <input name="theater_name" value="{{ old('theater_name', $theater->theater_name ?? '') }}" required
            class="mt-2 w-full rounded-xl bg-white/90 px-4 py-2 text-sm text-slate-900">
    </label>
    <label class="text-sm">
        Location
        <input name="location" value="{{ old('location', $theater->location ?? '') }}" required
            class="mt-2 w-full rounded-xl bg-white/90 px-4 py-2 text-sm text-slate-900">
    </label>
    <label class="text-sm">
        Capacity
        <input name="capacity" type="number" min="1" value="{{ old('capacity', $theater->capacity ?? '') }}" required
            class="mt-2 w-full rounded-xl bg-white/90 px-4 py-2 text-sm text-slate-900">
    </label>
</div>
