<x-admin-layout :title="'Manage Seats'">
    <div class="mb-6 flex flex-wrap items-center gap-4">
        <a href="{{ route('admin.seats.create') }}" class="rounded-full bg-orange-500 px-4 py-2 text-sm font-semibold text-black">Add Seat</a>
        <form method="GET" class="flex items-center gap-2">
            <select name="theater_id" class="rounded-full bg-white/90 px-4 py-2 text-sm text-slate-900">
                <option value="">All Theaters</option>
                @foreach ($theaters as $theater)
                    <option value="{{ $theater->id }}" @selected((string) $theaterId === (string) $theater->id)>{{ $theater->theater_name }}</option>
                @endforeach
            </select>
            <button class="rounded-full border border-white/30 px-4 py-2 text-xs font-semibold text-white/80 hover:text-white">Filter</button>
        </form>
    </div>

    <div class="overflow-hidden rounded-2xl bg-black/60 shadow-glow">
        <table class="w-full text-left text-sm">
            <thead class="bg-white/5 text-xs uppercase text-white/60">
                <tr>
                    <th class="px-4 py-3">Theater</th>
                    <th class="px-4 py-3">Seat</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($seats as $seat)
                    <tr class="border-t border-white/10">
                        <td class="px-4 py-3">{{ $seat->theater->theater_name }}</td>
                        <td class="px-4 py-3">{{ $seat->seat_number }}</td>
                        <td class="px-4 py-3">{{ ucfirst($seat->seat_status) }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <a class="text-orange-300" href="{{ route('admin.seats.edit', $seat) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.seats.destroy', $seat) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-400">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin-layout>
