@extends('layouts.app')
@section('title', 'Quick care — Carevia')

@section('content')
<section class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <a href="{{ route('dashboard') }}" class="text-sm text-ink-500 hover:text-ink-900 inline-flex items-center gap-1 mb-5">← Back</a>

    <div class="card p-8">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-primary-50 grid place-items-center text-2xl">⚡</div>
            <div>
                <h1 class="text-2xl font-extrabold text-ink-900">Quick care request</h1>
                <p class="text-sm text-ink-500">Tell us what's going on and we'll match you with a specialist.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('quick-care.store') }}" class="mt-6 space-y-5">
            @csrf

            <div>
                <label class="text-sm font-semibold text-ink-900">What kind of care do you need?</label>
                <select name="specialty_id" class="input mt-2" required>
                    <option value="">Choose a specialty...</option>
                    @foreach($specialties as $spec)
                        <option value="{{ $spec->id }}" @selected(old('specialty_id') == $spec->id)>{{ $spec->icon }} {{ $spec->name }}</option>
                    @endforeach
                </select>
                @error('specialty_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="text-sm font-semibold text-ink-900">Describe your symptoms</label>
                <textarea name="reason" rows="5" class="input mt-2" placeholder="e.g. I've had a sore throat for 3 days, mild fever, no other symptoms..." required>{{ old('reason') }}</textarea>
                @error('reason')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="text-sm font-semibold text-ink-900">How urgent is it?</label>
                <div class="mt-2 grid grid-cols-3 gap-2">
                    @foreach(['low' => '🟢 Not urgent', 'normal' => '🟡 Soon', 'high' => '🔴 Urgent'] as $val => $label)
                    <label class="cursor-pointer">
                        <input type="radio" name="urgency" value="{{ $val }}" @checked(old('urgency', 'normal') === $val) class="peer hidden" required>
                        <div class="rounded-2xl border-2 border-gray-100 p-3 text-center text-sm font-semibold text-ink-700 peer-checked:border-primary-500 peer-checked:bg-primary-50 transition hover:border-primary-200">{{ $label }}</div>
                    </label>
                    @endforeach
                </div>
                @error('urgency')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="pt-2 flex justify-end gap-3">
                <a href="{{ route('dashboard') }}" class="btn-secondary">Cancel</a>
                <button class="btn-primary !py-3 !px-6">Submit request</button>
            </div>
        </form>
    </div>
</section>
@endsection
