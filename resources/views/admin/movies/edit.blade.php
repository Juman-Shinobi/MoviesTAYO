<x-admin-layout :title="'Edit Movie'">
    <form method="POST" action="{{ route('admin.movies.update', $movie) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        @include('admin.movies.form', ['movie' => $movie])
        <button class="rounded-full bg-orange-500 px-6 py-2 text-sm font-semibold text-black">Update Movie</button>
    </form>
</x-admin-layout>
