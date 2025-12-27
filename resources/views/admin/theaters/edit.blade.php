<x-admin-layout :title="'Edit Theater'">
    <form method="POST" action="{{ route('admin.theaters.update', $theater) }}" class="space-y-6">
        @csrf
        @method('PUT')
        @include('admin.theaters.form', ['theater' => $theater])
        <button class="rounded-full bg-orange-500 px-6 py-2 text-sm font-semibold text-black">Update Theater</button>
    </form>
</x-admin-layout>
