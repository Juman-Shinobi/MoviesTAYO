<x-admin-layout :title="'Add Movie'">
    <form method="POST" action="{{ route('admin.movies.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @include('admin.movies.form')
        <div class="flex items-center gap-3">
            <button class="rounded-full bg-orange-500 px-6 py-2 text-sm font-semibold text-black">Save Movie</button>
            <a href="{{ route('admin.movies.index') }}" class="rounded-full border border-white/30 px-6 py-2 text-sm font-semibold text-white/80 hover:text-white">
                Cancel
            </a>
        </div>
    </form>
</x-admin-layout>
