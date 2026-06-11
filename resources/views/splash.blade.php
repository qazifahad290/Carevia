@extends('layouts.app')
@section('title', 'Carevia')
@section('content')
<div x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)" class="min-h-screen grid place-items-center bg-gradient-to-br from-primary-500 via-primary-600 to-primary-800 px-6">
    <div x-show="show" x-transition:enter="transition duration-700" class="text-center">
        <div class="w-20 h-20 mx-auto rounded-3xl bg-white/15 backdrop-blur grid place-items-center">
            <svg class="w-12 h-12 text-white" viewBox="0 0 40 40" fill="none">
                <path d="M20 30.5c-.4 0-.8-.13-1.13-.4-3.06-2.46-7.62-6.5-7.62-10.85 0-3.07 2.43-5.5 5.5-5.5 1.7 0 3.27.78 4.25 2 .98-1.22 2.55-2 4.25-2 3.07 0 5.5 2.43 5.5 5.5 0 4.35-4.56 8.39-7.62 10.85-.33.27-.73.4-1.13.4Z" fill="white"/>
                <rect x="18.4" y="17.5" width="3.2" height="8" rx="1" fill="#5B2EE6"/>
                <rect x="16" y="19.9" width="8" height="3.2" rx="1" fill="#5B2EE6"/>
            </svg>
        </div>
        <h1 class="mt-6 text-3xl font-extrabold text-white tracking-tight">Carevia</h1>
        <p class="mt-2 text-primary-200 text-sm">Your health, simplified.</p>
        <div x-data="{ load: false }" x-init="setTimeout(() => load = true, 1800); if (load) window.location.href = '{{ auth()->check() ? auth()->user()->dashboardRoute() : route('login') }}'" class="mt-10">
            <div class="flex justify-center">
                <svg class="animate-spin h-8 w-8 text-white/60" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>
            </div>
            <p class="mt-3 text-primary-200 text-xs">Loading your experience...</p>
        </div>
    </div>
</div>
<script>
    setTimeout(function() {
        window.location.href = '{{ auth()->check() ? auth()->user()->dashboardRoute() : route("login") }}';
    }, 2500);
</script>
@endsection
