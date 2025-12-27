<x-admin-layout :title="'Edit Seat'">
    <form method="POST" action="{{ route('admin.seats.update', $seat) }}" class="space-y-6">
        @csrf
        @method('PUT')
        @include('admin.seats.form', ['seat' => $seat])
        <button class="rounded-full bg-orange-500 px-6 py-2 text-sm font-semibold text-black">Update Seat</button>
    </form>
</x-admin-layout>
