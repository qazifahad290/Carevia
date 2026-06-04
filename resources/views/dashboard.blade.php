@extends('layouts.app')
@section('title', 'Home — Carevia')

@section('content')
<section class="bg-gradient-to-br from-primary-50 to-surface-100 border-b border-primary-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid lg:grid-cols-3 gap-6 items-center">
            <div class="lg:col-span-2">
                <span class="chip bg-white text-primary-700">👋 Welcome back, {{ explode(' ', auth()->user()->name)[0] }}</span>
                <h1 class="mt-3 text-3xl lg:text-4xl font-extrabold text-ink-900">How are you feeling today?</h1>
                <p class="mt-2 text-ink-500">Search a doctor, browse specialties, or request quick care.</p>
                <form action="{{ route('doctors.index') }}" method="GET" class="mt-5 flex gap-2 max-w-2xl">
                    <div class="flex-1 relative">
                        <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-ink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/></svg>
                        <input type="text" name="q" placeholder="Search doctors, specialties, conditions..." class="input pl-12 !py-3.5">
                    </div>
                    <button class="btn-primary !py-3 !px-6">Search</button>
                </form>
            </div>
            <a href="{{ route('quick-care.create') }}" class="card p-6 bg-gradient-to-br from-primary-500 to-primary-700 text-white border-0 group">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-primary-100">Quick Care</div>
                        <div class="mt-1 text-xl font-bold">Need help fast?</div>
                        <div class="mt-1 text-sm text-primary-100">Tell us your symptoms and we'll match a specialist.</div>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-white/15 grid place-items-center text-2xl group-hover:scale-110 transition">⚡</div>
                </div>
            </a>
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-end justify-between mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-ink-900">Browse by specialty</h2>
            <p class="text-sm text-ink-500 mt-1">Find the right doctor for what you need.</p>
        </div>
        <a href="{{ route('doctors.index') }}" class="text-sm font-semibold text-primary-600 hover:text-primary-700">View all →</a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($specialties as $spec)
        <a href="{{ route('doctors.index', ['specialty' => $spec->id]) }}" class="card p-5 text-center hover:shadow-cardHover hover:-translate-y-0.5 transition group">
            <div class="w-12 h-12 mx-auto rounded-2xl bg-primary-50 grid place-items-center text-2xl group-hover:bg-primary-100">{{ $spec->icon }}</div>
            <div class="mt-3 text-sm font-semibold text-ink-900">{{ $spec->name }}</div>
            <div class="text-xs text-ink-500 mt-0.5">{{ $spec->doctors_count }} doctors</div>
        </a>
        @endforeach
    </div>
</section>

@if($todays->count())
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-4">
    <h2 class="text-2xl font-extrabold text-ink-900 mb-5">Your upcoming visits</h2>
    <div class="grid md:grid-cols-3 gap-4">
        @foreach($todays as $appt)
        <a href="{{ route('appointments.index') }}" class="card p-5 flex items-center gap-4 hover:shadow-cardHover transition">
            <img src="{{ $appt->doctor->photoUrl() }}" class="w-14 h-14 rounded-2xl object-cover" alt="">
            <div class="flex-1 min-w-0">
                <div class="text-xs font-semibold text-primary-600 uppercase tracking-wider">{{ $appt->date->format('M d') }} · {{ \Carbon\Carbon::parse($appt->time)->format('g:i A') }}</div>
                <div class="font-bold text-ink-900 truncate">Dr. {{ $appt->doctor->name }}</div>
                <div class="text-sm text-ink-500 truncate">{{ $appt->doctor->specialty->name }}</div>
            </div>
        </a>
        @endforeach
    </div>
</section>
@endif

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-end justify-between mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-ink-900">Top-rated doctors</h2>
            <p class="text-sm text-ink-500 mt-1">Trusted specialists patients love.</p>
        </div>
        <a href="{{ route('doctors.index') }}" class="text-sm font-semibold text-primary-600 hover:text-primary-700">See more →</a>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($topDoctors as $doc)
        <a href="{{ route('doctors.show', $doc) }}" class="card p-5 hover:shadow-cardHover transition group">
            <div class="flex items-start gap-4">
                <img src="{{ $doc->photoUrl() }}" class="w-16 h-16 rounded-2xl object-cover" alt="">
                <div class="flex-1 min-w-0">
                    <div class="text-xs font-semibold text-primary-600 uppercase tracking-wider">{{ $doc->specialty->name }}</div>
                    <div class="font-bold text-ink-900 truncate">Dr. {{ $doc->name }}</div>
                    <div class="text-sm text-ink-500 truncate">{{ $doc->years_experience }} yrs · {{ $doc->location }}</div>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between pt-4 border-t border-gray-100">
                <div class="flex items-center gap-1 text-amber-500 text-sm font-semibold">★ {{ $doc->rating }}</div>
                <div class="text-sm">
                    <span class="text-ink-500">from </span>
                    <span class="font-bold text-ink-900">${{ $doc->price }}</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</section>
@endsection
