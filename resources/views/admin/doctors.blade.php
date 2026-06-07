@extends('layouts.app')
@section('title', 'Doctors — Admin')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-primary-600 hover:text-primary-700">← Back to overview</a>
    <h1 class="mt-2 text-3xl font-extrabold text-ink-900">All providers</h1>
    <p class="mt-1 text-ink-500">Provider profiles, their login accounts, and appointment totals.</p>

    <div class="mt-6 card overflow-hidden">
        <table class="w-full">
            <thead class="bg-surface-50 border-b border-gray-100">
                <tr>
                    <th class="text-left text-xs font-semibold uppercase tracking-wider text-ink-500 px-5 py-3">Provider</th>
                    <th class="text-left text-xs font-semibold uppercase tracking-wider text-ink-500 px-5 py-3">Specialty</th>
                    <th class="text-left text-xs font-semibold uppercase tracking-wider text-ink-500 px-5 py-3 hidden md:table-cell">Email</th>
                    <th class="text-left text-xs font-semibold uppercase tracking-wider text-ink-500 px-5 py-3">Rating</th>
                    <th class="text-left text-xs font-semibold uppercase tracking-wider text-ink-500 px-5 py-3">Appointments</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($doctors as $doc)
                    <tr class="hover:bg-surface-50">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-2">
                                <img src="{{ $doc->photoUrl() }}" class="w-9 h-9 rounded-full object-cover" alt="">
                                <div>
                                    <div class="text-sm font-semibold text-ink-900">Dr. {{ $doc->name }}</div>
                                    <div class="text-xs text-ink-500">{{ $doc->years_experience }} yrs · {{ $doc->location }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-sm text-ink-700">
                            <span class="mr-1">{{ $doc->specialty->icon }}</span>{{ $doc->specialty->name }}
                        </td>
                        <td class="px-5 py-3 text-sm text-ink-500 hidden md:table-cell">{{ $doc->user?->email ?? '—' }}</td>
                        <td class="px-5 py-3 text-sm font-semibold text-amber-600">★ {{ $doc->rating }}</td>
                        <td class="px-5 py-3 text-sm font-bold text-ink-900">{{ $doc->appointments_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
