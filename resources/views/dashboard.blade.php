@extends('layouts.app')
@section('title', 'Home — Carevia')
@section('content')
<div class="max-w-2xl mx-auto">
    {{-- Top bar --}}
    <div class="px-5 pt-6 pb-4 flex items-center justify-between">
        <div>
            <p class="text-xs text-ink-500 font-semibold uppercase tracking-wider">{{ now()->format('l, M d') }}</p>
            <h1 class="text-xl font-extrabold text-ink-900 mt-0.5">Hello, {{ explode(' ', auth()->user()->name)[0] }}! 👋</h1>
        </div>
        <a href="{{ route('appointments.index') }}" class="relative w-10 h-10 rounded-full bg-white shadow-sm grid place-items-center">
            <svg class="w-5 h-5 text-ink-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            @if(\App\Models\Appointment::where('patient_id', auth()->id())->where('date', '>=', now()->toDateString())->where('status', 'confirmed')->count() > 0)
                <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-red-500"></span>
            @endif
        </a>
    </div>

    {{-- Search bar --}}
    <div class="px-5 mb-6">
        <form action="{{ route('doctors.index') }}" method="GET">
            <div class="relative">
                <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-ink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/></svg>
                <input type="text" name="q" placeholder="Search doctors, specialties..." class="w-full pl-12 pr-4 py-3.5 rounded-2xl bg-white shadow-sm border-0 focus:ring-2 focus:ring-primary-200 outline-none text-sm">
            </div>
        </form>
    </div>

    {{-- Categories --}}
    <div class="px-5 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-extrabold text-ink-900">Categories</h2>
            <a href="{{ route('doctors.index') }}" class="text-xs font-semibold text-primary-600">See all</a>
        </div>
        <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide -mx-5 px-5">
            @foreach($specialties as $spec)
                <a href="{{ route('doctors.index', ['specialty' => $spec->id]) }}" class="flex-shrink-0 w-24 text-center">
                    <div class="w-full aspect-square rounded-2xl bg-white shadow-sm grid place-items-center text-3xl hover:shadow-md transition">
                        {{ $spec->icon }}
                    </div>
                    <p class="mt-2 text-xs font-semibold text-ink-700 truncate">{{ $spec->name }}</p>
                    <p class="text-[10px] text-ink-400">{{ $spec->doctors_count }} doctors</p>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Quick Care card --}}
    <div class="px-5 mb-6">
        <a href="{{ route('quick-care.create') }}" class="block rounded-2xl bg-gradient-to-r from-primary-500 to-primary-700 p-5 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-primary-200">Quick Care</p>
                    <p class="mt-1 text-lg font-bold">Need help fast?</p>
                    <p class="mt-0.5 text-sm text-primary-100">Tell us symptoms, we match a specialist.</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-white/15 grid place-items-center text-2xl">⚡</div>
            </div>
        </a>
    </div>

    {{-- Today's visits --}}
    @if($todays->count())
    <div class="px-5 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-extrabold text-ink-900">Today's visits</h2>
            <a href="{{ route('appointments.index') }}" class="text-xs font-semibold text-primary-600">View all</a>
        </div>
        <div class="space-y-3">
            @foreach($todays as $appt)
                <a href="{{ route('appointments.index') }}" class="flex items-center gap-4 bg-white rounded-2xl p-4 shadow-sm">
                    <img src="{{ $appt->doctor->photoUrl() }}" class="w-14 h-14 rounded-xl object-cover" alt="">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-primary-600">{{ $appt->date->format('M d') }} · {{ \Carbon\Carbon::parse($appt->time)->format('g:i A') }}</p>
                        <p class="font-bold text-ink-900 truncate">Dr. {{ $appt->doctor->name }}</p>
                        <p class="text-xs text-ink-500 truncate">{{ $appt->doctor->specialty->name }}</p>
                    </div>
                    <span class="chip bg-green-50 text-green-700 text-xs">Confirmed</span>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Top rated doctors --}}
    <div class="px-5 pb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-extrabold text-ink-900">Top doctors</h2>
            <a href="{{ route('doctors.index') }}" class="text-xs font-semibold text-primary-600">See all</a>
        </div>
        <div class="space-y-3">
            @foreach($topDoctors as $doc)
                <a href="{{ route('doctors.show', $doc) }}" class="flex items-center gap-4 bg-white rounded-2xl p-4 shadow-sm hover:shadow-md transition">
                    <img src="{{ $doc->photoUrl() }}" class="w-16 h-16 rounded-xl object-cover" alt="">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-primary-600 uppercase">{{ $doc->specialty->name }}</p>
                        <p class="font-bold text-ink-900 truncate">Dr. {{ $doc->name }}</p>
                        <p class="text-xs text-ink-500">{{ $doc->years_experience }} yrs exp</p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-xs font-semibold text-amber-500">★ {{ $doc->rating }}</span>
                            <span class="text-xs text-ink-400">·</span>
                            <span class="text-xs font-semibold text-ink-700">${{ $doc->price }}</span>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-ink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
