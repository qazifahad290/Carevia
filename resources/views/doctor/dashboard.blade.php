@extends('layouts.app')
@section('title', 'Provider dashboard — Carevia')

@section('content')
<section class="bg-gradient-to-br from-amber-50 to-surface-100 border-b border-amber-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">
            <div>
                <span class="chip bg-white text-amber-700">🩺 Provider portal</span>
                <h1 class="mt-3 text-3xl lg:text-4xl font-extrabold text-ink-900">Dr. {{ $doctor->name }}</h1>
                <p class="mt-1 text-ink-500">{{ $doctor->specialty->name }} · {{ $doctor->years_experience }} yrs experience · {{ $doctor->location }}</p>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 md:max-w-2xl w-full">
                <div class="card p-4">
                    <div class="text-xs font-semibold uppercase tracking-wider text-ink-500">Today</div>
                    <div class="mt-1 text-2xl font-extrabold text-ink-900">{{ $stats['today'] }}</div>
                </div>
                <div class="card p-4">
                    <div class="text-xs font-semibold uppercase tracking-wider text-ink-500">Upcoming</div>
                    <div class="mt-1 text-2xl font-extrabold text-ink-900">{{ $stats['upcoming'] }}</div>
                </div>
                <div class="card p-4">
                    <div class="text-xs font-semibold uppercase tracking-wider text-ink-500">Completed</div>
                    <div class="mt-1 text-2xl font-extrabold text-green-600">{{ $stats['completed'] }}</div>
                </div>
                <div class="card p-4">
                    <div class="text-xs font-semibold uppercase tracking-wider text-ink-500">Cancelled</div>
                    <div class="mt-1 text-2xl font-extrabold text-red-500">{{ $stats['cancelled'] }}</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    @if(session('status'))
        <div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-200 text-sm text-green-800">{{ session('status') }}</div>
    @endif

    <div class="flex items-end justify-between mb-5">
        <div>
            <h2 class="text-2xl font-extrabold text-ink-900">Today's schedule</h2>
            <p class="text-sm text-ink-500 mt-1">{{ now()->format('l, F j, Y') }}</p>
        </div>
    </div>

    @if($today->count())
        <div class="space-y-3">
            @foreach($today as $appt)
                <div class="card p-5">
                    <div class="flex flex-col md:flex-row md:items-center gap-4">
                        <div class="flex items-center gap-4 flex-1 min-w-0">
                            <div class="w-14 h-14 rounded-2xl bg-amber-50 grid place-items-center text-amber-700 font-bold text-lg">
                                {{ \Carbon\Carbon::parse($appt->time)->format('g:i') }}
                            </div>
                            <img src="{{ $appt->patient->avatarUrl() }}" class="w-12 h-12 rounded-full object-cover" alt="">
                            <div class="flex-1 min-w-0">
                                <div class="font-bold text-ink-900 truncate">{{ $appt->patient->name }}</div>
                                <div class="text-sm text-ink-500 truncate">{{ $appt->patient->email }}@if($appt->patient->phone) · {{ $appt->patient->phone }}@endif</div>
                                @if($appt->notes)
                                    <div class="mt-1 text-xs text-ink-500 italic line-clamp-1">"{{ $appt->notes }}"</div>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="chip bg-green-50 text-green-700">{{ ucfirst($appt->status) }}</span>
                            <form method="POST" action="{{ route('doctor.appointments.complete', $appt) }}" onsubmit="return confirm('Mark this visit as completed?')">
                                @csrf
                                @method('PATCH')
                                <button class="btn-primary !py-2 !px-4 !text-xs">Mark complete</button>
                            </form>
                            <form method="POST" action="{{ route('doctor.appointments.cancel', $appt) }}" onsubmit="return confirm('Cancel this appointment?')">
                                @csrf
                                @method('PATCH')
                                <button class="btn-secondary !py-2 !px-4 !text-xs">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card p-12 text-center">
            <div class="text-5xl">☕</div>
            <h3 class="mt-4 text-lg font-bold text-ink-900">No appointments today</h3>
            <p class="mt-1 text-sm text-ink-500">Enjoy the day off, or check the upcoming list below.</p>
        </div>
    @endif
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
    <h2 class="text-2xl font-extrabold text-ink-900 mb-5">Upcoming appointments</h2>
    @if($upcoming->count())
        <div class="card overflow-hidden">
            <table class="w-full">
                <thead class="bg-surface-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left text-xs font-semibold uppercase tracking-wider text-ink-500 px-5 py-3">Date</th>
                        <th class="text-left text-xs font-semibold uppercase tracking-wider text-ink-500 px-5 py-3">Time</th>
                        <th class="text-left text-xs font-semibold uppercase tracking-wider text-ink-500 px-5 py-3">Patient</th>
                        <th class="text-left text-xs font-semibold uppercase tracking-wider text-ink-500 px-5 py-3 hidden md:table-cell">Reason</th>
                        <th class="text-right text-xs font-semibold uppercase tracking-wider text-ink-500 px-5 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($upcoming as $appt)
                        <tr class="hover:bg-surface-50">
                            <td class="px-5 py-3 text-sm font-semibold text-ink-900">{{ $appt->date->format('M d, Y') }}</td>
                            <td class="px-5 py-3 text-sm text-ink-700">{{ \Carbon\Carbon::parse($appt->time)->format('g:i A') }}</td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2">
                                    <img src="{{ $appt->patient->avatarUrl() }}" class="w-8 h-8 rounded-full object-cover" alt="">
                                    <span class="text-sm font-semibold text-ink-900">{{ $appt->patient->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-sm text-ink-500 hidden md:table-cell max-w-xs truncate">{{ $appt->notes ?: '—' }}</td>
                            <td class="px-5 py-3 text-right">
                                <form method="POST" action="{{ route('doctor.appointments.cancel', $appt) }}" onsubmit="return confirm('Cancel this appointment?')" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="text-xs font-semibold text-red-600 hover:text-red-700">Cancel</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="card p-8 text-center text-sm text-ink-500">No upcoming appointments booked.</div>
    @endif
</section>

@if($recent->count())
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    <h2 class="text-2xl font-extrabold text-ink-900 mb-5">Recent history</h2>
    <div class="card overflow-hidden">
        <table class="w-full">
            <thead class="bg-surface-50 border-b border-gray-100">
                <tr>
                    <th class="text-left text-xs font-semibold uppercase tracking-wider text-ink-500 px-5 py-3">Date</th>
                    <th class="text-left text-xs font-semibold uppercase tracking-wider text-ink-500 px-5 py-3">Patient</th>
                    <th class="text-left text-xs font-semibold uppercase tracking-wider text-ink-500 px-5 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($recent as $appt)
                    <tr>
                        <td class="px-5 py-3 text-sm text-ink-700">{{ $appt->date->format('M d, Y') }} · {{ \Carbon\Carbon::parse($appt->time)->format('g:i A') }}</td>
                        <td class="px-5 py-3 text-sm text-ink-900">{{ $appt->patient->name }}</td>
                        <td class="px-5 py-3">
                            <span class="chip {{ $appt->status === 'completed' ? 'bg-green-50 text-green-700' : ($appt->status === 'cancelled' ? 'bg-red-50 text-red-700' : 'bg-gray-100 text-ink-500') }}">{{ ucfirst($appt->status) }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endif
@endsection
