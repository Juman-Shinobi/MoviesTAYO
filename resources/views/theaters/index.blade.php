<x-app-layout>
    <div class="space-y-6">
        <h1 class="text-2xl font-display">Theaters</h1>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($theaters as $theater)
                <div class="rounded-3xl border border-white/20 bg-black/60 p-6 shadow-glow">
                    <h2 class="text-lg font-semibold">{{ $theater->theater_name }}</h2>
                    <p class="mt-2 text-sm text-white/70">{{ $theater->location }}</p>
                    <p class="mt-2 text-sm text-white/70">Capacity: {{ $theater->capacity }}</p>
                </div>
            @empty
                <p class="text-white/60">No theaters yet.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
