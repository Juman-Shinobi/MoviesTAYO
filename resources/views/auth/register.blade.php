<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="text-sm font-semibold text-slate-700">Fullname</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                class="mt-2 w-full rounded-full border border-slate-200 bg-slate-100 px-4 py-3 text-sm focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600" />
        </div>

        <div>
            <label for="email" class="text-sm font-semibold text-slate-700">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                class="mt-2 w-full rounded-full border border-slate-200 bg-slate-100 px-4 py-3 text-sm focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
        </div>

        <div>
            <label for="password" class="text-sm font-semibold text-slate-700">Enter Password</label>
            <div class="mt-2 flex items-center gap-2 rounded-full border border-slate-200 bg-slate-100 px-4 py-3">
                <input id="password" name="password" type="password" required
                    class="w-full appearance-none border-0 bg-transparent text-sm outline-none shadow-none focus:outline-none focus:ring-0">
                <button type="button" class="text-orange-500" data-toggle="password" aria-label="Toggle password visibility">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" data-eye-open>
                        <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z" stroke="currentColor" stroke-width="1.5"/>
                        <circle cx="12" cy="12" r="3.5" stroke="currentColor" stroke-width="1.5"/>
                    </svg>
                    <svg class="hidden h-5 w-5" viewBox="0 0 24 24" fill="none" data-eye-closed>
                        <path d="M3 5l18 14" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M2 12s3.5-6 10-6c3.2 0 5.7 1.4 7.5 3" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M6 15.5C4 14 2 12 2 12s3.5 6 10 6c2.7 0 4.9-1 6.5-2.3" stroke="currentColor" stroke-width="1.5"/>
                        <circle cx="12" cy="12" r="3.5" stroke="currentColor" stroke-width="1.5"/>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
        </div>

        <div>
            <label for="password_confirmation" class="text-sm font-semibold text-slate-700">Confirm Password</label>
            <div class="mt-2 flex items-center gap-2 rounded-full border border-slate-200 bg-slate-100 px-4 py-3">
                <input id="password_confirmation" name="password_confirmation" type="password" required
                    class="w-full appearance-none border-0 bg-transparent text-sm outline-none shadow-none focus:outline-none focus:ring-0">
                <button type="button" class="text-orange-500" data-toggle="password" aria-label="Toggle password visibility">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" data-eye-open>
                        <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z" stroke="currentColor" stroke-width="1.5"/>
                        <circle cx="12" cy="12" r="3.5" stroke="currentColor" stroke-width="1.5"/>
                    </svg>
                    <svg class="hidden h-5 w-5" viewBox="0 0 24 24" fill="none" data-eye-closed>
                        <path d="M3 5l18 14" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M2 12s3.5-6 10-6c3.2 0 5.7 1.4 7.5 3" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M6 15.5C4 14 2 12 2 12s3.5 6 10 6c2.7 0 4.9-1 6.5-2.3" stroke="currentColor" stroke-width="1.5"/>
                        <circle cx="12" cy="12" r="3.5" stroke="currentColor" stroke-width="1.5"/>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
        </div>

        <p class="text-xs text-slate-600">
            Or continue to
            <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-500">Login</a>
        </p>

        <button type="submit" class="w-full rounded-full bg-orange-500 py-3 text-sm font-semibold text-black transition hover:-translate-y-0.5 hover:bg-orange-400 hover:shadow-lg">
            Register
        </button>
    </form>

    <script>
        document.querySelectorAll('[data-toggle="password"]').forEach((button) => {
            button.addEventListener('click', () => {
                const input = button.parentElement.querySelector('input');
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                button.querySelector('[data-eye-open]').classList.toggle('hidden', !isPassword);
                button.querySelector('[data-eye-closed]').classList.toggle('hidden', isPassword);
            });
        });
    </script>
</x-guest-layout>
