@extends('layouts.app')
@section('title', 'Dr. ' . $doctor->name . ' — Carevia')
@section('content')
<div class="max-w-lg mx-auto pb-8">
    <div class="relative">
        <img src="{{ $doctor->photoUrl() }}" class="w-full aspect-[4/3] object-cover" alt="">
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
        <a href="{{ route('doctors.index') }}" class="absolute top-6 left-5 w-10 h-10 rounded-full bg-white/20 backdrop-blur grid place-items-center">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
    </div>

    <div class="-mt-8 relative z-10 px-5">
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <div class="flex items-start justify-between">
                <div>
                    <span class="chip bg-primary-50 text-primary-700 text-xs">{{ $doctor->specialty->icon }} {{ $doctor->specialty->name }}</span>
                    <h1 class="mt-2 text-2xl font-extrabold text-ink-900">Dr. {{ $doctor->name }}</h1>
                    <p class="text-sm text-ink-500">{{ $doctor->years_experience }} years · {{ $doctor->location }}</p>
                </div>
                <div class="text-right">
                    <div class="flex items-center gap-1 text-amber-500 font-extrabold text-lg">★ {{ $doctor->rating }}</div>
                    <p class="text-xs text-ink-400">{{ $reviews->count() }} reviews</p>
                </div>
            </div>

            <div class="mt-5 flex items-center justify-between p-4 bg-surface-50 rounded-2xl">
                <div>
                    <p class="text-xs text-ink-500 font-semibold uppercase tracking-wider">Consultation fee</p>
                    <p class="text-2xl font-extrabold text-ink-900">${{ $doctor->price }}<span class="text-sm text-ink-500 font-normal">/visit</span></p>
                </div>
                <a href="{{ route('booking.create', $doctor) }}" class="btn-primary !py-3 !px-6">Book now</a>
            </div>
        </div>

        <div class="mt-6 bg-white rounded-2xl shadow-sm p-5">
            <h2 class="font-extrabold text-ink-900">About</h2>
            <p class="mt-2 text-sm text-ink-700 leading-relaxed">{{ $doctor->bio }}</p>
        </div>

        <div class="mt-6 bg-white rounded-2xl shadow-sm p-5">
            <h2 class="font-extrabold text-ink-900">Ratings & reviews</h2>
            <div class="mt-3 flex items-center gap-4">
                <div class="text-center">
                    <div class="text-4xl font-extrabold text-ink-900">{{ $doctor->rating }}</div>
                    <div class="flex items-center gap-0.5 mt-1">
                        @for($i=1; $i<=5; $i++)
                            <svg class="w-4 h-4 {{ $i <= round($doctor->rating) ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <p class="text-xs text-ink-400 mt-1">{{ $reviews->count() }} reviews</p>
                </div>
            </div>

            <div class="mt-5 space-y-4">
                @foreach($reviews as $review)
                <div class="flex gap-3 pb-4 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                    <img src="https://i.pravatar.cc/60?img={{ $review->avatar }}" class="w-10 h-10 rounded-full object-cover" alt="">
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <p class="font-semibold text-ink-900 text-sm">{{ $review->name }}</p>
                            <span class="text-xs text-ink-400">{{ $review->date }}</span>
                        </div>
                        <div class="flex items-center gap-0.5 mt-0.5">
                            @for($i=1; $i<=5; $i++)
                                <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <p class="mt-1 text-sm text-ink-600">{{ $review->text }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
