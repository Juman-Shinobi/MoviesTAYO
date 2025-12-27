<x-admin-layout :title="'Add Account'">
    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
        @csrf
        <div class="grid gap-4 sm:grid-cols-2">
            <label class="text-sm">
                Full Name
                <input name="name" value="{{ old('name') }}" required
                    class="mt-2 w-full rounded-xl bg-white/90 px-4 py-2 text-sm text-slate-900">
            </label>
            <label class="text-sm">
                Email
                <input name="email" type="email" value="{{ old('email') }}" required
                    class="mt-2 w-full rounded-xl bg-white/90 px-4 py-2 text-sm text-slate-900">
            </label>
            <label class="text-sm">
                Password
                <div class="mt-2 flex items-center gap-2 rounded-xl bg-white/90 px-4 py-2">
                    <input name="password" type="password" required
                        class="w-full appearance-none border-0 bg-transparent text-sm text-slate-900 outline-none shadow-none focus:outline-none focus:ring-0">
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
            </label>
            <label class="text-sm">
                Role
                <select name="role" class="mt-2 w-full rounded-xl bg-white/90 px-4 py-2 text-sm text-slate-900">
                    <option value="admin">Admin</option>
                    <option value="employee">Employee</option>
                </select>
            </label>
        </div>
        <div class="flex items-center gap-3">
            <button class="rounded-full bg-orange-500 px-6 py-2 text-sm font-semibold text-black">Create Account</button>
            <a href="{{ route('admin.users.index') }}" class="rounded-full border border-white/30 px-6 py-2 text-sm font-semibold text-white/80 hover:text-white">
                Cancel
            </a>
        </div>
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
</x-admin-layout>
