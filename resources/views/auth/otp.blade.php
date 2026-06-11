@extends('layouts.app')
@section('title', 'Verify OTP — Carevia')
@section('content')
<div class="px-6 py-10 max-w-sm mx-auto">
    <div class="text-center">
        <div class="w-16 h-16 mx-auto rounded-2xl bg-primary-50 grid place-items-center">
            <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        </div>
        <h1 class="mt-4 text-2xl font-extrabold text-ink-900">Enter OTP</h1>
        <p class="mt-1 text-sm text-ink-500">We sent a code to<br><span class="font-semibold text-ink-700">+1 (555) 123-4567</span></p>
    </div>

    <form class="mt-8">
        <div class="flex justify-center gap-3">
            @for($i=0; $i<6; $i++)
            <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="one-time-code"
                   class="otp-input w-12 h-14 text-center text-xl font-bold rounded-2xl border-2 border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 outline-none"
                   x-data
                   x-init="$el.addEventListener('input', function() {
                       if(this.value && this.nextElementSibling) this.nextElementSibling.focus();
                   })">
            @endfor
        </div>

        <div class="mt-6">
            <button type="submit" class="btn-primary w-full !py-3.5 !text-base">Verify</button>
        </div>
    </form>

    <p class="mt-6 text-center text-sm text-ink-500">
        Didn't receive? <a href="#" class="font-semibold text-primary-600">Resend</a>
    </p>
</div>
@endsection
