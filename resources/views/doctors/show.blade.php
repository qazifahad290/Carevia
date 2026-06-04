@extends('layouts.app')
@section('title', 'Dr. ' . $doctor->name . ' — Carevia')

@section('content')
<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <a href="{{ route('doctors.index') }}" class="text-sm text-ink-500 hover:text-ink-900 inline-flex items-center gap-1 mb-5">← Back to doctors</a>

    <div class="card p-8">
        <div class="grid md:grid-cols-3 gap-6 items-start">
            <div class="md:col-span-1">
                <img src="{{ $doctor->photoUrl() }}" class="w-full aspect-square rounded-2.5xl object-cover" alt="">
            </div>
            <div class="md:col-span-2">
                <span class="chip bg-primary-50 text-primary-700">{{ $doctor->specialty->icon }} {{ $doctor->specialty->name }}</span>
                <h1 class="mt-3 text-3xl font-extrabold text-ink-900">Dr. {{ $doctor->name }}</h1>
                <p class="mt-1 text-ink-500">{{ $doctor->years_experience }} years of experience · {{ $doctor->location }}</p>

                <div class="mt-4 flex flex-wrap items-center gap-4 text-sm">
                    <div class="flex items-center gap-1 text-amber-500 font-semibold">★ {{ $doctor->rating }} <span class="text-ink-500 font-normal">rating</span></div>
                    <div class="text-ink-500">·</div>
                    <div class="text-ink-500">{{ $doctor->schedules->count() > 0 ? 'Available this week' : 'Schedule TBA' }}</div>
                </div>

                <p class="mt-5 text-ink-700 leading-relaxed">{{ $doctor->bio }}</p>

                <div class="mt-7 flex items-center justify-between gap-3 p-5 bg-surface-100 rounded-2xl">
                    <div>
                        <div class="text-xs font-semibold text-ink-500 uppercase tracking-wider">Consultation fee</div>
                        <div class="text-3xl font-extrabold text-ink-900">${{ $doctor->price }}<span class="text-sm text-ink-500 font-normal">/visit</span></div>
                    </div>
                    <a href="{{ route('booking.create', $doctor) }}" class="btn-primary !py-3 !px-6">Book a visit</a>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 card p-7">
        <h2 class="text-xl font-bold text-ink-900 mb-4">What to expect</h2>
        <div class="grid sm:grid-cols-3 gap-4">
            <div class="p-4 rounded-2xl bg-primary-50">
                <div class="text-2xl">📅</div>
                <div class="mt-2 font-semibold text-ink-900">Pick a slot</div>
                <p class="text-sm text-ink-500 mt-1">Choose a date and time that works for you.</p>
            </div>
            <div class="p-4 rounded-2xl bg-primary-50">
                <div class="text-2xl">✅</div>
                <div class="mt-2 font-semibold text-ink-900">Confirm booking</div>
                <p class="text-sm text-ink-500 mt-1">Get instant confirmation. Reschedule any time.</p>
            </div>
            <div class="p-4 rounded-2xl bg-primary-50">
                <div class="text-2xl">🩺</div>
                <div class="mt-2 font-semibold text-ink-900">Visit doctor</div>
                <p class="text-sm text-ink-500 mt-1">Show up at the clinic and get the care you need.</p>
            </div>
        </div>
    </div>
</section>
@endsection
