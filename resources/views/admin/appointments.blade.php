@extends('layouts.app')
@section('title', 'Appointments — Admin')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-primary-600 hover:text-primary-700">← Back to overview</a>
    <h1 class="mt-2 text-3xl font-extrabold text-ink-900">All appointments</h1>
    <p class="mt-1 text-ink-500">Every booking made on the platform.</p>

    <div class="mt-6 card overflow-hidden">
        <table class="w-full">
            <thead class="bg-surface-50 border-b border-gray-100">
                <tr>
                    <th class="text-left text-xs font-semibold uppercase tracking-wider text-ink-500 px-5 py-3">Date / Time</th>
                    <th class="text-left text-xs font-semibold uppercase tracking-wider text-ink-500 px-5 py-3">Patient</th>
                    <th class="text-left text-xs font-semibold uppercase tracking-wider text-ink-500 px-5 py-3">Provider</th>
                    <th class="text-left text-xs font-semibold uppercase tracking-wider text-ink-500 px-5 py-3 hidden md:table-cell">Notes</th>
                    <th class="text-left text-xs font-semibold uppercase tracking-wider text-ink-500 px-5 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($appointments as $appt)
                    <tr class="hover:bg-surface-50">
                        <td class="px-5 py-3 text-sm text-ink-900">
                            <div class="font-semibold">{{ $appt->date->format('M d, Y') }}</div>
                            <div class="text-xs text-ink-500">{{ \Carbon\Carbon::parse($appt->time)->format('g:i A') }}</div>
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-2">
                                <img src="{{ $appt->patient->avatarUrl() }}" class="w-8 h-8 rounded-full object-cover" alt="">
                                <span class="text-sm font-semibold text-ink-900">{{ $appt->patient->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3">
                            <div class="text-sm font-semibold text-ink-900">Dr. {{ $appt->doctor->name }}</div>
                            <div class="text-xs text-ink-500">{{ $appt->doctor->specialty->name }}</div>
                        </td>
                        <td class="px-5 py-3 text-sm text-ink-500 hidden md:table-cell max-w-xs truncate">{{ $appt->notes ?: '—' }}</td>
                        <td class="px-5 py-3">
                            <span class="chip {{ $appt->status === 'confirmed' ? 'bg-green-50 text-green-700' : ($appt->status === 'cancelled' ? 'bg-red-50 text-red-700' : 'bg-gray-100 text-ink-500') }}">{{ ucfirst($appt->status) }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $appointments->links() }}</div>
</section>
@endsection
