<x-admin-layout :title="'Manage Movies'">
    <div class="mb-6">
        <a href="{{ route('admin.movies.create') }}" class="rounded-full bg-orange-500 px-4 py-2 text-sm font-semibold text-black">Add Movie</a>
    </div>

    <div class="overflow-hidden rounded-2xl bg-black/60 shadow-glow">
        <table class="w-full text-left text-sm">
            <thead class="bg-white/5 text-xs uppercase text-white/60">
                <tr>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Genre</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Release</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($movies as $movie)
                    <tr class="border-t border-white/10">
                        <td class="px-4 py-3">{{ $movie->title }}</td>
                        <td class="px-4 py-3">{{ $movie->genre }}</td>
                        <td class="px-4 py-3">{{ str_replace('_', ' ', ucfirst($movie->status)) }}</td>
                        <td class="px-4 py-3">{{ $movie->release_date->format('M d, Y') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <a class="text-orange-300" href="{{ route('admin.movies.edit', $movie) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.movies.destroy', $movie) }}">
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
