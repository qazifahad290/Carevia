@extends('layouts.app')
@section('title', 'Quick Care — Carevia')
@section('content')
<div class="max-w-lg mx-auto px-5 py-8">
    <a href="{{ route('dashboard') }}" class="text-sm text-ink-500 hover:text-ink-900 inline-flex items-center gap-1 mb-5">← Back</a>
    <h1 class="text-2xl font-extrabold text-ink-900">Quick Care</h1>
    <p class="mt-1 text-sm text-ink-500">Tell us what's wrong, and we'll match you with the right specialist.</p>

    <form method="POST" action="{{ route('quick-care.store') }}" class="mt-6 space-y-5">
        @csrf
        <div>
            <label class="text-sm font-semibold text-ink-900">What type of care do you need?</label>
            <select name="specialty_id" class="input mt-2" required>
                <option value="">Select a specialty</option>
                @foreach($specialties as $spec)
                    <option value="{{ $spec->id }}" @selected(old('specialty_id') == $spec->id)>{{ $spec->icon }} {{ $spec->name }}</option>
                @endforeach
            </select>
            @error('specialty_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="text-sm font-semibold text-ink-900">How urgent is this?</label>
            <div class="mt-2 grid grid-cols-3 gap-2">
                @foreach(['low' => 'Low', 'normal' => 'Normal', 'urgent' => 'Urgent'] as $val => $label)
                <label class="cursor-pointer">
                    <input type="radio" name="urgency" value="{{ $val }}" class="peer hidden" @checked(old('urgency', 'normal') === $val)>
                    <div class="rounded-2xl border-2 border-gray-100 py-3 text-center text-sm font-semibold text-ink-700 peer-checked:border-primary-500 peer-checked:bg-primary-50 transition">{{ $label }}</div>
                </label>
                @endforeach
            </div>
            @error('urgency')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="text-sm font-semibold text-ink-900">Describe your symptoms</label>
            <textarea name="reason" rows="4" class="input mt-2" placeholder="Headache, fever, abdominal pain..." required>{{ old('reason') }}</textarea>
            @error('reason')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <button type="submit" class="btn-primary w-full !py-3.5">Submit request</button>
    </form>
</div>
@endsection
