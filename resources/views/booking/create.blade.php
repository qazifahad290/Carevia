@extends('layouts.app')
@section('title', 'Book Dr. ' . $doctor->name . ' — Carevia')

@section('content')
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <a href="{{ route('doctors.show', $doctor) }}" class="text-sm text-ink-500 hover:text-ink-900 inline-flex items-center gap-1 mb-5">← Back to doctor</a>

    <h1 class="text-3xl font-extrabold text-ink-900">Book your visit</h1>
    <p class="mt-1 text-ink-500">Pick a date and time that works best for you.</p>

    <form method="POST" action="{{ route('booking.store', $doctor) }}" class="mt-8 card p-7" x-data="{ date: '', time: '', loading: false, slots: [] }">
        @csrf

        <div class="card p-4 bg-surface-100 border-0 mb-6 flex items-center gap-4">
            <img src="{{ $doctor->photoUrl() }}" class="w-14 h-14 rounded-2xl object-cover" alt="">
            <div>
                <div class="text-xs font-semibold text-primary-600 uppercase tracking-wider">{{ $doctor->specialty->name }}</div>
                <div class="font-bold text-ink-900">Dr. {{ $doctor->name }}</div>
                <div class="text-sm text-ink-500">${{ $doctor->price }} / visit</div>
            </div>
        </div>

        <div>
            <label class="text-sm font-semibold text-ink-900">1. Choose a date</label>
            <div class="mt-3 grid grid-cols-4 sm:grid-cols-7 gap-2">
                @foreach($nextDays as $d)
                <label class="cursor-pointer">
                    <input type="radio" name="date" value="{{ $d->toDateString() }}" x-model="date" class="peer hidden" @change="loading = true; fetch('{{ route('booking.slots', $doctor) }}?date=' + $el.value).then(r => r.json()).then(d => { slots = d.slots; time = ''; loading = false; })" required>
                    <div class="rounded-2xl border-2 border-gray-100 p-3 text-center peer-checked:border-primary-500 peer-checked:bg-primary-50 transition hover:border-primary-200">
                        <div class="text-[10px] font-semibold text-ink-500 uppercase">{{ $d->format('D') }}</div>
                        <div class="text-lg font-extrabold text-ink-900">{{ $d->format('d') }}</div>
                        <div class="text-[10px] text-ink-500">{{ $d->format('M') }}</div>
                    </div>
                </label>
                @endforeach
            </div>
            @error('date')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mt-6">
            <label class="text-sm font-semibold text-ink-900">2. Choose a time</label>
            <div class="mt-3" x-show="!date">
                <p class="text-sm text-ink-500 italic">Pick a date above to see available time slots.</p>
            </div>
            <div class="mt-3" x-show="date && loading">
                <p class="text-sm text-ink-500 italic">Loading slots…</p>
            </div>
            <div class="mt-3" x-show="date && !loading && slots.length === 0">
                <p class="text-sm text-ink-500 italic">No slots available on this day. Please try another date.</p>
            </div>
            <div class="mt-3 grid grid-cols-3 sm:grid-cols-5 gap-2" x-show="date && !loading && slots.length > 0">
                <template x-for="slot in slots" :key="slot">
                    <label class="cursor-pointer">
                        <input type="radio" name="time" :value="slot" x-model="time" class="peer hidden" required>
                        <div class="rounded-xl border-2 border-gray-100 py-2 text-center text-sm font-semibold text-ink-700 peer-checked:border-primary-500 peer-checked:bg-primary-500 peer-checked:text-white transition hover:border-primary-200" x-text="slot"></div>
                    </label>
                </template>
            </div>
            @error('time')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mt-6">
            <label class="text-sm font-semibold text-ink-900">3. Notes for the doctor (optional)</label>
            <textarea name="notes" rows="3" class="input mt-2" placeholder="Briefly describe your symptoms or reason for the visit...">{{ old('notes') }}</textarea>
            @error('notes')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mt-7 flex justify-end gap-3">
            <a href="{{ route('doctors.show', $doctor) }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary !py-3 !px-6" :disabled="!date || !time">Confirm booking</button>
        </div>
    </form>
</section>
@endsection
