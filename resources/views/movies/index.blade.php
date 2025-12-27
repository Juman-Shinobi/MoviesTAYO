<x-app-layout>
    <div class="space-y-12">
        <section>
            <div class="mb-6">
                <h2 class="text-3xl font-display">MOVIES</h2>
                <p class="text-orange-400">Now Showing</p>
            </div>

            <div class="relative">
                <button type="button" id="now-showing-prev"
                    class="absolute -left-6 top-1/2 z-10 hidden h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-orange-500 text-black shadow-glow transition hover:bg-orange-400 md:flex"
                    aria-label="Scroll left">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.78 4.22a.75.75 0 010 1.06L9.06 9l3.72 3.72a.75.75 0 11-1.06 1.06l-4.25-4.25a.75.75 0 010-1.06l4.25-4.25a.75.75 0 011.06 0z" clip-rule="evenodd"/>
                    </svg>
                </button>
                <button type="button" id="now-showing-next"
                    class="absolute -right-6 top-1/2 z-10 hidden h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-orange-500 text-black shadow-glow transition hover:bg-orange-400 md:flex"
                    aria-label="Scroll right">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.22 4.22a.75.75 0 011.06 0l4.25 4.25a.75.75 0 010 1.06l-4.25 4.25a.75.75 0 11-1.06-1.06L10.94 9 7.22 5.28a.75.75 0 010-1.06z" clip-rule="evenodd"/>
                    </svg>
                </button>

                <div id="now-showing-scroll" class="flex gap-6 overflow-hidden scroll-smooth pb-2">
                    @forelse ($nowShowing as $movie)
                        <a href="{{ route('movies.show', $movie) }}" class="group flex-shrink-0 basis-[calc((100%-4.5rem)/4)]">
                            <div class="overflow-hidden rounded-2xl bg-black/60 shadow-glow">
                                <img src="{{ $movie->poster_path ? asset($movie->poster_path) : asset('images/posters/avatar movie.jpg') }}"
                                    alt="{{ $movie->title }}" class="h-96 w-full object-cover transition duration-300 group-hover:scale-105">
                            </div>
                            <p class="mt-3 text-center text-sm font-semibold text-white">{{ $movie->title }}</p>
                        </a>
                    @empty
                        <p class="text-white/60">No movies available.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section>
            <div class="mb-6">
                <h2 class="text-2xl font-display">Coming Soon</h2>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @forelse ($comingSoon as $movie)
                    <a href="{{ route('movies.show', $movie) }}" class="group">
                        <div class="overflow-hidden rounded-2xl bg-black/60 shadow-glow">
                            <img src="{{ $movie->poster_path ? asset($movie->poster_path) : asset('images/posters/housemaid.jpg') }}"
                                alt="{{ $movie->title }}" class="h-96 w-full object-cover transition duration-300 group-hover:scale-105">
                        </div>
                        <p class="mt-3 text-center text-sm font-semibold text-white">{{ $movie->title }}</p>
                    </a>
                @empty
                    <p class="text-white/60">No upcoming movies yet.</p>
                @endforelse
            </div>
        </section>
    </div>

    <script>
        const nowShowing = document.getElementById('now-showing-scroll');
        const prevBtn = document.getElementById('now-showing-prev');
        const nextBtn = document.getElementById('now-showing-next');

        if (nowShowing && prevBtn && nextBtn) {
            const scrollAmount = nowShowing.clientWidth;
            prevBtn.addEventListener('click', () => nowShowing.scrollBy({ left: -scrollAmount, behavior: 'smooth' }));
            nextBtn.addEventListener('click', () => nowShowing.scrollBy({ left: scrollAmount, behavior: 'smooth' }));
        }
    </script>
</x-app-layout>
