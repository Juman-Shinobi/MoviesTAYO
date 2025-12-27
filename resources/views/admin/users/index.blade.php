<x-admin-layout :title="'Accounts'">
    <div class="mb-6 flex flex-wrap items-center gap-4">
        <a href="{{ route('admin.users.create') }}" class="rounded-full bg-orange-500 px-4 py-2 text-sm font-semibold text-black">Add Account</a>
        <form method="GET" class="flex flex-1 items-center gap-2" id="account-filter-form">
            <input
                name="search"
                type="text"
                value="{{ $search }}"
                placeholder="Search name"
                class="w-full max-w-xs rounded-full bg-white/90 px-4 py-2 text-sm text-slate-900"
                id="account-search"
            >
            <select name="role" class="rounded-full bg-white/90 px-4 py-2 text-sm text-slate-900">
                <option value="">All Roles</option>
                @foreach (['admin' => 'Admin', 'employee' => 'Employee', 'customer' => 'Customer'] as $value => $label)
                    <option value="{{ $value }}" @selected($role->toString() === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <button class="rounded-full border border-white/30 px-4 py-2 text-xs font-semibold text-white/80 hover:text-white">
                Filter
            </button>
        </form>
    </div>

    <script>
        const searchInput = document.getElementById('account-search');
        const filterForm = document.getElementById('account-filter-form');
        let searchTimer;

        if (searchInput && filterForm) {
            searchInput.addEventListener('input', () => {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => {
                    filterForm.submit();
                }, 300);
            });
        }
    </script>

    <div class="overflow-hidden rounded-2xl bg-black/60 shadow-glow">
        <table class="w-full text-left text-sm">
            <thead class="bg-white/5 text-xs uppercase text-white/60">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-t border-white/10">
                        <td class="px-4 py-3">{{ $user->name }}</td>
                        <td class="px-4 py-3">{{ $user->email }}</td>
                        <td class="px-4 py-3">{{ ucfirst($user->role) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin-layout>
