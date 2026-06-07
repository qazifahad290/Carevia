@extends('layouts.app')
@section('title', 'Users — Admin')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-primary-600 hover:text-primary-700">← Back to overview</a>
    <h1 class="mt-2 text-3xl font-extrabold text-ink-900">All users</h1>
    <p class="mt-1 text-ink-500">Everyone with a Carevia account, including patients, providers, and admins.</p>

    <div class="mt-6 card overflow-hidden">
        <table class="w-full">
            <thead class="bg-surface-50 border-b border-gray-100">
                <tr>
                    <th class="text-left text-xs font-semibold uppercase tracking-wider text-ink-500 px-5 py-3">Name</th>
                    <th class="text-left text-xs font-semibold uppercase tracking-wider text-ink-500 px-5 py-3">Email</th>
                    <th class="text-left text-xs font-semibold uppercase tracking-wider text-ink-500 px-5 py-3">Role</th>
                    <th class="text-left text-xs font-semibold uppercase tracking-wider text-ink-500 px-5 py-3 hidden md:table-cell">Phone</th>
                    <th class="text-left text-xs font-semibold uppercase tracking-wider text-ink-500 px-5 py-3 hidden md:table-cell">Joined</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($users as $u)
                    <tr class="hover:bg-surface-50">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-2">
                                <img src="{{ $u->avatarUrl() }}" class="w-8 h-8 rounded-full object-cover" alt="">
                                <span class="text-sm font-semibold text-ink-900">{{ $u->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-sm text-ink-500">{{ $u->email }}</td>
                        <td class="px-5 py-3">
                            <span class="chip {{ $u->role === 'doctor' ? 'bg-amber-50 text-amber-700' : ($u->role === 'admin' ? 'bg-rose-50 text-rose-700' : 'bg-primary-50 text-primary-700') }}">{{ ucfirst($u->role) }}</span>
                        </td>
                        <td class="px-5 py-3 text-sm text-ink-500 hidden md:table-cell">{{ $u->phone ?: '—' }}</td>
                        <td class="px-5 py-3 text-sm text-ink-500 hidden md:table-cell">{{ $u->created_at->format('M d, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $users->links() }}</div>
</section>
@endsection
