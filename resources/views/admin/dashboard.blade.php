<x-admin-layout :title="'Dashboard'">
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl bg-black/60 p-5 shadow-glow">
            <p class="text-xs uppercase text-white/60">Movies</p>
            <p class="mt-2 text-2xl font-semibold">{{ $movieCount }}</p>
        </div>
        <div class="rounded-2xl bg-black/60 p-5 shadow-glow">
            <p class="text-xs uppercase text-white/60">Theaters</p>
            <p class="mt-2 text-2xl font-semibold">{{ $theaterCount }}</p>
        </div>
        <div class="rounded-2xl bg-black/60 p-5 shadow-glow">
            <p class="text-xs uppercase text-white/60">Showtimes</p>
            <p class="mt-2 text-2xl font-semibold">{{ $showtimeCount }}</p>
        </div>
        <div class="rounded-2xl bg-black/60 p-5 shadow-glow">
            <p class="text-xs uppercase text-white/60">Pending Reservations</p>
            <p class="mt-2 text-2xl font-semibold">{{ $pendingCount }}</p>
        </div>
    </div>
</x-admin-layout>
