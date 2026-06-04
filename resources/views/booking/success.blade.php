@extends('layouts.app')
@section('title', 'Booking confirmed — Carevia')

@section('content')
<section class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
    <div class="card p-10">
        <div class="w-20 h-20 mx-auto rounded-full bg-green-100 grid place-items-center text-4xl">✅</div>
        <h1 class="mt-6 text-3xl font-extrabold text-ink-900">Booking confirmed</h1>
        <p class="mt-2 text-ink-500">Your visit has been scheduled. We've got you covered.</p>

        <div class="mt-8 card p-5 bg-surface-100 border-0 text-left">
            <div class="flex items-center gap-4">
                <img src="{{ $appointment->doctor->photoUrl() }}" class="w-14 h-14 rounded-2xl object-cover" alt="">
                <div>
                    <div class="text-xs font-semibold text-primary-600 uppercase tracking-wider">{{ $appointment->doctor->specialty->name }}</div>
                    <div class="font-bold text-ink-900">Dr. {{ $appointment->doctor->name }}</div>
                </div>
            </div>
            <div class="mt-5 grid grid-cols-2 gap-4 pt-5 border-t border-gray-200">
                <div>
                    <div class="text-xs font-semibold text-ink-500 uppercase tracking-wider">Date</div>
                    <div class="mt-1 font-bold text-ink-900">{{ $appointment->date->format('l, M d, Y') }}</div>
                </div>
                <div>
                    <div class="text-xs font-semibold text-ink-500 uppercase tracking-wider">Time</div>
                    <div class="mt-1 font-bold text-ink-900">{{ \Carbon\Carbon::parse($appointment->time)->format('g:i A') }}</div>
                </div>
            </div>
        </div>

        <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('appointments.index') }}" class="btn-primary !py-3 !px-6">View my appointments</a>
            <a href="{{ route('dashboard') }}" class="btn-secondary !py-3 !px-6">Back to home</a>
        </div>
    </div>
</section>
@endsection
