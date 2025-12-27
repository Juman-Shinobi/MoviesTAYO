<x-admin-layout :title="'Logs'">
    <div class="overflow-hidden rounded-2xl bg-black/60 shadow-glow">
        <table class="w-full text-left text-sm">
            <thead class="bg-white/5 text-xs uppercase text-white/60">
                <tr>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Action</th>
                    <th class="px-4 py-3">Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    <tr class="border-t border-white/10">
                        <td class="px-4 py-3">{{ $log->created_at->format('M d, Y H:i') }}</td>
                        <td class="px-4 py-3">{{ $log->user?->email ?? 'System' }}</td>
                        <td class="px-4 py-3">{{ $log->action }}</td>
                        <td class="px-4 py-3">{{ $log->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin-layout>
