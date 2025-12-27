<x-app-layout>
    <div class="grid gap-10 lg:grid-cols-[1.1fr_1fr]">
        <section class="space-y-6">
            <div class="flex flex-col gap-6 sm:flex-row">
                <img src="{{ $movie->poster_path ? asset($movie->poster_path) : asset('images/posters/avatar movie.jpg') }}"
                    alt="{{ $movie->title }}" class="h-72 w-52 rounded-2xl object-cover shadow-glow">
                <div class="space-y-2">
                    <h1 class="text-3xl font-display">{{ $movie->title }}</h1>
                    <p class="text-sm text-blue-400">{{ $movie->rating ?? 'PG-13' }}</p>
                    <p class="text-sm text-white/80">Duration: {{ $movie->duration }} min</p>
                    <p class="text-sm text-white/80">Genre: {{ $movie->genre }}</p>
                    <p class="text-sm text-white/80">Release Date: {{ $movie->release_date->format('M d, Y') }}</p>
                </div>
            </div>

            <div>
                <h2 class="text-lg font-semibold">Description</h2>
                <p class="mt-2 text-sm text-white/70">{{ $movie->description }}</p>
            </div>

            <div class="h-px w-1/2 bg-white/20"></div>
            <h2 class="text-lg font-semibold">Reserve A Seat</h2>
        </section>

        <section class="rounded-3xl bg-black/50 p-6 shadow-glow">
            <form method="POST" action="{{ route('reservations.store') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="showtime_id" id="showtime_id">

                <div class="grid gap-4 sm:grid-cols-3">
                    <label class="text-xs uppercase text-white/60">
                        Theater
                        <select id="theater_select" class="mt-2 w-full rounded-full bg-white/90 px-4 py-2 text-sm text-slate-900">
                            <option value="">Select Theater</option>
                            @foreach ($theaters as $theaterData)
                                <option value="{{ $theaterData['theater']->id }}">{{ $theaterData['theater']->theater_name }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="text-xs uppercase text-white/60">
                        Date
                        <select id="date_select" class="mt-2 w-full rounded-full bg-white/90 px-4 py-2 text-sm text-slate-900" disabled>
                            <option value="">Select Date</option>
                        </select>
                    </label>
                    <label class="text-xs uppercase text-white/60">
                        Showtime
                        <select id="time_select" class="mt-2 w-full rounded-full bg-white/90 px-4 py-2 text-sm text-slate-900" disabled>
                            <option value="">Select Showtime</option>
                        </select>
                    </label>
                </div>

                <div>
                    <p class="text-sm font-semibold">Select Seats</p>
                    <div id="seat_notice" class="mt-4 flex h-52 items-center justify-center rounded-2xl bg-white/10 text-sm text-white/70">
                        Seat Selection will be available once you select the theater, date, and showtime.
                    </div>
                    <div id="seat_map" class="mt-4 hidden rounded-2xl bg-white/10 p-4">
                        <div class="mb-4 rounded bg-red-600/80 py-2 text-center text-xs uppercase text-white">
                            Screen is this way
                        </div>
                        <div id="seat_grid" class="grid grid-cols-8 gap-2 text-xs"></div>
                        <div class="mt-4 flex flex-wrap gap-4 text-xs text-white/80">
                            <span class="flex items-center gap-2">
                                <span class="h-3 w-3 rounded bg-slate-300"></span> Available seat
                            </span>
                            <span class="flex items-center gap-2">
                                <span class="h-3 w-3 rounded bg-slate-600"></span> Reserved seat
                            </span>
                            <span class="flex items-center gap-2">
                                <span class="h-3 w-3 rounded bg-red-600"></span> Selected seat
                            </span>
                        </div>
                    </div>
                    <div id="selected_seats"></div>
                    <x-input-error :messages="$errors->get('seats')" class="mt-2 text-sm text-red-400" />
                </div>

                <button type="submit" id="reserve-submit" disabled class="relative w-full overflow-hidden rounded-full bg-slate-400 py-3 text-sm font-semibold text-slate-800 transition disabled:cursor-not-allowed">
                    <span class="absolute inset-0 -translate-x-full bg-gradient-to-r from-emerald-300 via-emerald-500 to-green-500 transition-transform duration-300"></span>
                    <span class="relative z-10">Reserve Now</span>
                </button>
            </form>
        </section>
    </div>

    <script>
        const showtimes = @json($showtimesPayload);

        const theaterSelect = document.getElementById('theater_select');
        const dateSelect = document.getElementById('date_select');
        const timeSelect = document.getElementById('time_select');
        const showtimeInput = document.getElementById('showtime_id');
        const seatNotice = document.getElementById('seat_notice');
        const seatMap = document.getElementById('seat_map');
        const seatGrid = document.getElementById('seat_grid');
        const selectedSeats = document.getElementById('selected_seats');
        const reserveSubmit = document.getElementById('reserve-submit');

        const setReserveState = (enabled) => {
            if (!reserveSubmit) {
                return;
            }
            reserveSubmit.disabled = !enabled;
            reserveSubmit.classList.toggle('bg-emerald-500', enabled);
            reserveSubmit.classList.toggle('text-black', enabled);
            reserveSubmit.classList.toggle('bg-slate-400', !enabled);
            reserveSubmit.classList.toggle('text-slate-800', !enabled);
            reserveSubmit.classList.toggle('group', enabled);
            const gradient = reserveSubmit.querySelector('span:first-child');
            if (gradient) {
                gradient.classList.toggle('group-hover:translate-x-0', enabled);
            }
        };

        const resetSeatMap = () => {
            seatGrid.innerHTML = '';
            selectedSeats.innerHTML = '';
            showtimeInput.value = '';
            seatNotice.classList.remove('hidden');
            seatMap.classList.add('hidden');
            setReserveState(false);
        };

        const fillDates = (theaterId) => {
            const dates = [...new Set(showtimes.filter(s => s.theater_id === Number(theaterId)).map(s => s.date))];
            dateSelect.innerHTML = '<option value="">Select Date</option>' + dates.map(date => `<option value="${date}">${date}</option>`).join('');
            dateSelect.disabled = dates.length === 0;
            timeSelect.innerHTML = '<option value="">Select Showtime</option>';
            timeSelect.disabled = true;
            resetSeatMap();
        };

        const fillTimes = (theaterId, date) => {
            const times = showtimes.filter(s => s.theater_id === Number(theaterId) && s.date === date);
            timeSelect.innerHTML = '<option value="">Select Showtime</option>' + times.map(s => `<option value="${s.id}">${s.time}</option>`).join('');
            timeSelect.disabled = times.length === 0;
            resetSeatMap();
        };

        const renderSeats = (seats) => {
            seatGrid.innerHTML = '';
            selectedSeats.innerHTML = '';
            seatNotice.classList.add('hidden');
            seatMap.classList.remove('hidden');
            setReserveState(false);

            seats.forEach(seat => {
                const button = document.createElement('button');
                button.type = 'button';
                button.textContent = seat.seat_number;
                button.dataset.seatId = seat.id;
                button.className = 'rounded px-2 py-2 text-[10px] font-semibold';

                if (seat.seat_status === 'reserved' || seat.seat_status === 'booked') {
                    button.classList.add('bg-slate-600', 'text-white/60', 'cursor-not-allowed');
                    button.disabled = true;
                } else {
                    button.classList.add('bg-slate-200', 'text-slate-900', 'hover:bg-red-500', 'hover:text-white');
                    button.addEventListener('click', () => {
                        button.classList.toggle('bg-red-600');
                        button.classList.toggle('text-white');
                        button.classList.toggle('bg-slate-200');
                        button.classList.toggle('text-slate-900');

                        const existing = selectedSeats.querySelector(`input[value="${seat.id}"]`);
                        if (existing) {
                            existing.remove();
                        } else {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'seats[]';
                            input.value = seat.id;
                            selectedSeats.appendChild(input);
                        }

                        const hasSelected = selectedSeats.querySelectorAll('input[name="seats[]"]').length > 0;
                        setReserveState(hasSelected);
                    });
                }

                seatGrid.appendChild(button);
            });
        };

        const loadSeats = (showtimeId) => {
            if (!showtimeId) {
                resetSeatMap();
                return;
            }
            fetch(`{{ url('/showtimes') }}/${showtimeId}/seats`)
                .then(response => response.json())
                .then(data => {
                    showtimeInput.value = showtimeId;
                    renderSeats(data.seats);
                });
        };

        theaterSelect.addEventListener('change', (event) => {
            fillDates(event.target.value);
        });

        dateSelect.addEventListener('change', (event) => {
            fillTimes(theaterSelect.value, event.target.value);
        });

        timeSelect.addEventListener('change', (event) => {
            loadSeats(event.target.value);
        });
    </script>
</x-app-layout>
