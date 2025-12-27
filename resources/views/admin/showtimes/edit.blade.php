<x-admin-layout :title="'Edit Showtime'">
    <form method="POST" action="{{ route('admin.showtimes.update', $showtime) }}" class="space-y-6">
        @csrf
        @method('PUT')
        @include('admin.showtimes.form', ['showtime' => $showtime])
        <button class="rounded-full bg-orange-500 px-6 py-2 text-sm font-semibold text-black">Update Showtime</button>
    </form>
</x-admin-layout>
