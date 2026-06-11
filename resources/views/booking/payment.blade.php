@extends('layouts.app')
@section('title', 'Payment — Carevia')
@section('content')
<div class="max-w-lg mx-auto px-5 py-8">
    <a href="{{ route('appointments.index') }}" class="text-sm text-ink-500 hover:text-ink-900 inline-flex items-center gap-1 mb-5">← Back to appointments</a>
    <h1 class="text-2xl font-extrabold text-ink-900">Complete payment</h1>
    <p class="mt-1 text-sm text-ink-500">Secure your appointment with a quick payment.</p>

    <div class="mt-6 bg-white rounded-2xl shadow-sm p-5">
        <p class="text-xs font-semibold text-ink-500 uppercase tracking-wider">Order summary</p>
        <div class="mt-3 flex items-center gap-4">
            <img src="{{ $appointment->doctor->photoUrl() }}" class="w-14 h-14 rounded-xl object-cover" alt="">
            <div class="flex-1 min-w-0">
                <p class="font-bold text-ink-900">Dr. {{ $appointment->doctor->name }}</p>
                <p class="text-xs text-ink-500">{{ $appointment->doctor->specialty->name }}</p>
                <p class="text-xs text-ink-500">{{ $appointment->date->format('D, M d, Y') }} · {{ \Carbon\Carbon::parse($appointment->time)->format('g:i A') }}</p>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
            <span class="text-ink-700 font-semibold">Consultation fee</span>
            <span class="text-xl font-extrabold text-ink-900">${{ $appointment->doctor->price }}</span>
        </div>
    </div>

    <form method="POST" action="{{ route('appointments.payment.process', $appointment) }}" class="mt-6 bg-white rounded-2xl shadow-sm p-5">
        @csrf
        <p class="text-xs font-semibold text-ink-500 uppercase tracking-wider">Card details (mock)</p>
        <div class="mt-4 space-y-4">
            <div>
                <label class="text-sm font-semibold text-ink-900">Cardholder name</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="input mt-1" required>
                @error('name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="text-sm font-semibold text-ink-900">Card number</label>
                <input type="text" name="card_number" value="{{ old('card_number', '4242 4242 4242 4242') }}" maxlength="19" class="input mt-1 font-mono" required>
                @error('card_number')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-semibold text-ink-900">Expiry</label>
                    <input type="text" name="expiry" value="{{ old('expiry', '12/28') }}" placeholder="MM/YY" maxlength="5" class="input mt-1" required>
                    @error('expiry')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-ink-900">CVV</label>
                    <input type="text" name="cvv" value="{{ old('cvv', '123') }}" maxlength="3" class="input mt-1" required>
                    @error('cvv')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>
        <button type="submit" class="btn-primary w-full !py-3.5 !text-base mt-6">Pay ${{ $appointment->doctor->price }} — Confirm booking</button>
        <p class="mt-3 text-xs text-ink-400 text-center">🔒 This is a mock payment. No real charges.</p>
    </form>
</div>
@endsection
