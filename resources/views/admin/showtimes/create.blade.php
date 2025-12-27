<x-admin-layout :title="'Add Showtime'">
    <form method="POST" action="{{ route('admin.showtimes.store') }}" class="space-y-6">
        @csrf
        @include('admin.showtimes.form')
        <div class="flex items-center gap-3">
            <button class="rounded-full bg-orange-500 px-6 py-2 text-sm font-semibold text-black">Save Showtime</button>
            <a href="{{ route('admin.showtimes.index') }}" class="rounded-full border border-white/30 px-6 py-2 text-sm font-semibold text-white/80 hover:text-white">
                Cancel
            </a>
        </div>
    </form>
</x-admin-layout>
