<div class="grid gap-4 sm:grid-cols-2">
    <label class="text-sm">
        Theater
        <select name="theater_id" class="mt-2 w-full rounded-xl bg-white/90 px-4 py-2 text-sm text-slate-900">
            @foreach ($theaters as $theater)
                <option value="{{ $theater->id }}" @selected(old('theater_id', $seat->theater_id ?? '') == $theater->id)>{{ $theater->theater_name }}</option>
            @endforeach
        </select>
    </label>
    <label class="text-sm">
        Seat Number
        <input name="seat_number" value="{{ old('seat_number', $seat->seat_number ?? '') }}" required
            class="mt-2 w-full rounded-xl bg-white/90 px-4 py-2 text-sm text-slate-900">
    </label>
    <label class="text-sm">
        Status
        <select name="seat_status" class="mt-2 w-full rounded-xl bg-white/90 px-4 py-2 text-sm text-slate-900">
            @foreach (['available', 'reserved', 'booked'] as $status)
                <option value="{{ $status }}" @selected(old('seat_status', $seat->seat_status ?? '') === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
    </label>
</div>
