@extends('layouts.app')
@section('title', 'Carevia — Book your doctor in minutes')

@section('content')
<section class="relative overflow-hidden">
    <div class="absolute -top-32 -right-32 w-96 h-96 bg-primary-200 rounded-full blur-3xl opacity-50"></div>
    <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-primary-100 rounded-full blur-3xl opacity-60"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-24 relative">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="chip bg-primary-50 text-primary-700">⚡ Quick Care available</span>
                <h1 class="mt-5 text-5xl lg:text-6xl font-extrabold tracking-tight text-ink-900 leading-tight">
                    Book your doctor, <span class="text-primary-600">the easy way.</span>
                </h1>
                <p class="mt-5 text-lg text-ink-500 max-w-lg">
                    Find trusted specialists, view real availability, and book your visit in under a minute. No calls, no waiting.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('register') }}" class="btn-primary !py-3 !px-6">Get started — it's free</a>
                    <a href="{{ route('login') }}" class="btn-secondary !py-3 !px-6">I have an account</a>
                </div>
                <div class="mt-10 grid grid-cols-3 gap-6 max-w-md">
                    <div>
                        <div class="text-3xl font-extrabold text-primary-600">500+</div>
                        <div class="text-sm text-ink-500">Verified doctors</div>
                    </div>
                    <div>
                        <div class="text-3xl font-extrabold text-primary-600">24/7</div>
                        <div class="text-sm text-ink-500">Quick care</div>
                    </div>
                    <div>
                        <div class="text-3xl font-extrabold text-primary-600">4.9★</div>
                        <div class="text-sm text-ink-500">Patient rating</div>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="card p-8 relative z-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-primary-50 grid place-items-center text-2xl">🩺</div>
                        <div>
                            <div class="text-xs font-semibold text-ink-500 uppercase tracking-wider">Today's pick</div>
                            <div class="text-lg font-bold text-ink-900">Top-rated doctors near you</div>
                        </div>
                    </div>
                    @if(isset($featured) && $featured->count())
                        <div class="space-y-3">
                            @foreach($featured->take(3) as $doc)
                            <a href="{{ route('doctors.show', $doc) }}" class="flex items-center gap-3 p-3 rounded-2xl hover:bg-surface-100 transition">
                                <img src="{{ $doc->photoUrl() }}" class="w-12 h-12 rounded-xl object-cover" alt="">
                                <div class="flex-1 min-w-0">
                                    <div class="font-semibold text-ink-900 truncate">Dr. {{ $doc->name }}</div>
                                    <div class="text-xs text-ink-500">{{ $doc->specialty->name }} · ★ {{ $doc->rating }}</div>
                                </div>
                                <div class="text-primary-600 font-semibold text-sm">${{ $doc->price }}</div>
                            </a>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="absolute -z-10 -top-6 -right-6 w-full h-full bg-primary-100 rounded-3xl"></div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto">
            <h2 class="text-4xl font-extrabold text-ink-900">Care that fits your life</h2>
            <p class="mt-3 text-ink-500">Three simple steps to feel better, sooner.</p>
        </div>
        <div class="mt-12 grid md:grid-cols-3 gap-6">
            <div class="card p-7">
                <div class="w-12 h-12 rounded-2xl bg-primary-50 grid place-items-center text-2xl">🔍</div>
                <h3 class="mt-4 text-lg font-bold text-ink-900">Find a doctor</h3>
                <p class="mt-2 text-sm text-ink-500">Browse specialists by category, see ratings and prices, and pick the right fit for you.</p>
            </div>
            <div class="card p-7">
                <div class="w-12 h-12 rounded-2xl bg-primary-50 grid place-items-center text-2xl">📅</div>
                <h3 class="mt-4 text-lg font-bold text-ink-900">Book a slot</h3>
                <p class="mt-2 text-sm text-ink-500">See real-time availability and confirm your appointment in a couple of clicks.</p>
            </div>
            <div class="card p-7">
                <div class="w-12 h-12 rounded-2xl bg-primary-50 grid place-items-center text-2xl">⚡</div>
                <h3 class="mt-4 text-lg font-bold text-ink-900">Quick care, anytime</h3>
                <p class="mt-2 text-sm text-ink-500">Not sure who to see? Submit a quick care request and we'll match you with a specialist.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-20">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center card p-12 bg-gradient-to-br from-primary-500 to-primary-700 text-white border-0">
        <h2 class="text-3xl lg:text-4xl font-extrabold">Ready to feel better?</h2>
        <p class="mt-3 text-primary-100 max-w-xl mx-auto">Create your free account in under a minute. Browse doctors, book your visit, and get reminders before your appointment.</p>
        <div class="mt-6 flex justify-center gap-3 flex-wrap">
            <a href="{{ route('register') }}" class="btn bg-white !text-primary-700 hover:bg-primary-50 !py-3 !px-6">Create free account</a>
            <a href="{{ route('login') }}" class="btn bg-white/10 !text-white hover:bg-white/20 !py-3 !px-6 border border-white/30">Log in</a>
        </div>
    </div>
</section>
@endsection
