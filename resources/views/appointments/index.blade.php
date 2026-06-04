@extends('layouts.app')
@section('title', 'My appointments — Carevia')

@section('content')
<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-3xl font-extrabold text-ink-900">My appointments</h1>
    <p class="mt-1 text-ink-500">Manage your upcoming and past visits.</p>

    @if(session('status'))
        <div class="mt-5 p-4 rounded-2xl bg-green-50 border border-green-200 text-sm text-green-800">{{ session('status') }}</div>
    @endif

    <div x-data="{ tab: 'upcoming' }" class="mt-8">
        <div class="flex gap-2 border-b border-gray-200">
            <button @click="tab = 'upcoming'" :class="tab === 'upcoming' ? 'border-primary-500 text-primary-600' : 'border-transparent text-ink-500'" class="px-4 py-3 text-sm font-semibold border-b-2 -mb-px">Upcoming ({{ $upcoming->count() }})</button>
            <button @click="tab = 'past'" :class="tab === 'past' ? 'border-primary-500 text-primary-600' : 'border-transparent text-ink-500'" class="px-4 py-3 text-sm font-semibold border-b-2 -mb-px">Past ({{ $past->count() }})</button>
            @if($quickCareRequests->count())
            <button @click="tab = 'quick'" :class="tab === 'quick' ? 'border-primary-500 text-primary-600' : 'border-transparent text-ink-500'" class="px-4 py-3 text-sm font-semibold border-b-2 -mb-px">Quick care ({{ $quickCareRequests->count() }})</button>
            @endif
        </div>

        <div x-show="tab === 'upcoming'" class="mt-6 space-y-3">
            @forelse($upcoming as $appt)
            <div class="card p-5 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <img src="{{ $appt->doctor->photoUrl() }}" class="w-14 h-14 rounded-2xl object-cover" alt="">
                <div class="flex-1 min-w-0">
                    <div class="text-xs font-semibold text-primary-600 uppercase tracking-wider">{{ $appt->doctor->specialty->name }}</div>
                    <div class="font-bold text-ink-900">Dr. {{ $appt->doctor->name }}</div>
                    <div class="text-sm text-ink-500">{{ $appt->date->format('l, M d, Y') }} · {{ \Carbon\Carbon::parse($appt->time)->format('g:i A') }}</div>
                </div>
                <span class="chip bg-green-50 text-green-700">Confirmed</span>
                <form method="POST" action="{{ route('appointments.cancel', $appt) }}" onsubmit="return confirm('Cancel this appointment?')">
                    @csrf
                    @method('PATCH')
                    <button class="btn-secondary !py-2 !px-4 !text-xs">Cancel</button>
                </form>
            </div>
            @empty
            <div class="card p-12 text-center">
                <div class="text-5xl">📅</div>
                <h3 class="mt-4 text-lg font-bold text-ink-900">No upcoming visits</h3>
                <p class="mt-1 text-sm text-ink-500">Ready to book? Find a doctor that fits your needs.</p>
                <a href="{{ route('doctors.index') }}" class="btn-primary mt-5 inline-flex">Find a doctor</a>
            </div>
            @endforelse
        </div>

        <div x-show="tab === 'past'" x-cloak class="mt-6 space-y-3">
            @forelse($past as $appt)
            <div class="card p-5 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <img src="{{ $appt->doctor->photoUrl() }}" class="w-14 h-14 rounded-2xl object-cover" alt="">
                <div class="flex-1 min-w-0">
                    <div class="text-xs font-semibold text-ink-500 uppercase tracking-wider">{{ $appt->doctor->specialty->name }}</div>
                    <div class="font-bold text-ink-900">Dr. {{ $appt->doctor->name }}</div>
                    <div class="text-sm text-ink-500">{{ $appt->date->format('l, M d, Y') }} · {{ \Carbon\Carbon::parse($appt->time)->format('g:i A') }}</div>
                </div>
                <span class="chip {{ $appt->status === 'cancelled' ? 'bg-red-50 text-red-700' : 'bg-gray-100 text-ink-500' }}">{{ ucfirst($appt->status) }}</span>
            </div>
            @empty
            <div class="card p-12 text-center">
                <div class="text-5xl">🗂</div>
                <h3 class="mt-4 text-lg font-bold text-ink-900">No past appointments yet</h3>
            </div>
            @endforelse
        </div>

        <div x-show="tab === 'quick'" x-cloak class="mt-6 space-y-3">
            @forelse($quickCareRequests as $req)
            <div class="card p-5 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-primary-50 grid place-items-center text-2xl">⚡</div>
                <div class="flex-1 min-w-0">
                    <div class="text-xs font-semibold text-primary-600 uppercase tracking-wider">{{ $req->specialty->name }} · {{ ucfirst($req->urgency) }} urgency</div>
                    <div class="text-sm text-ink-900 mt-1 line-clamp-2">{{ $req->reason }}</div>
                    <div class="text-xs text-ink-500 mt-1">Submitted {{ $req->created_at->diffForHumans() }}</div>
                </div>
                <span class="chip {{ $req->status === 'pending' ? 'bg-amber-50 text-amber-700' : 'bg-green-50 text-green-700' }}">{{ ucfirst($req->status) }}</span>
            </div>
            @empty
            <div class="card p-12 text-center">
                <div class="text-5xl">⚡</div>
                <h3 class="mt-4 text-lg font-bold text-ink-900">No quick care requests</h3>
                <p class="mt-1 text-sm text-ink-500">Need help fast? Submit a request and we'll match you.</p>
                <a href="{{ route('quick-care.create') }}" class="btn-primary mt-5 inline-flex">Request quick care</a>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
