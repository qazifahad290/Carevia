@extends('layouts.app')
@section('title', 'Page not found — Carevia')

@section('content')
<section class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
    <div class="text-6xl">🩺</div>
    <h1 class="mt-6 text-4xl font-extrabold text-ink-900">Page not found</h1>
    <p class="mt-2 text-ink-500">We couldn't find what you were looking for. Let's get you back on track.</p>
    <div class="mt-8 flex justify-center gap-3 flex-wrap">
        <a href="{{ route('home') }}" class="btn-primary !py-3 !px-6">Back to home</a>
        <a href="{{ route('doctors.index') }}" class="btn-secondary !py-3 !px-6">Find a doctor</a>
    </div>
</section>
@endsection
