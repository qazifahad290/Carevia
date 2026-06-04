@extends('layouts.app')
@section('title', 'Find a doctor — Carevia')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex items-end justify-between mb-6">
        <div>
            <h1 class="text-3xl font-extrabold text-ink-900">Find a doctor</h1>
            <p class="mt-1 text-ink-500">{{ $doctors->total() }} doctors available</p>
        </div>
    </div>

    <form method="GET" action="{{ route('doctors.index') }}" class="card p-5 mb-8">
        <div class="grid md:grid-cols-12 gap-3">
            <div class="md:col-span-5">
                <label class="text-xs font-semibold text-ink-500">Search</label>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Doctor name or condition..." class="input mt-1">
            </div>
            <div class="md:col-span-4">
                <label class="text-xs font-semibold text-ink-500">Specialty</label>
                <select name="specialty" class="input mt-1">
                    <option value="">All specialties</option>
                    @foreach($specialties as $spec)
                        <option value="{{ $spec->id }}" @selected(request('specialty') == $spec->id)>{{ $spec->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="text-xs font-semibold text-ink-500">Sort by</label>
                <select name="sort" class="input mt-1">
                    <option value="rating"     @selected(request('sort', 'rating') == 'rating')>Top rated</option>
                    <option value="price_asc"  @selected(request('sort') == 'price_asc')>Price: low → high</option>
                    <option value="price_desc" @selected(request('sort') == 'price_desc')>Price: high → low</option>
                    <option value="experience" @selected(request('sort') == 'experience')>Most experienced</option>
                </select>
            </div>
            <div class="md:col-span-1 flex items-end">
                <button class="btn-primary w-full !py-2.5">Apply</button>
            </div>
        </div>
    </form>

    @if($doctors->count())
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($doctors as $doc)
            <a href="{{ route('doctors.show', $doc) }}" class="card p-5 hover:shadow-cardHover transition group">
                <div class="flex items-start gap-4">
                    <img src="{{ $doc->photoUrl() }}" class="w-16 h-16 rounded-2xl object-cover" alt="">
                    <div class="flex-1 min-w-0">
                        <div class="text-xs font-semibold text-primary-600 uppercase tracking-wider">{{ $doc->specialty->name }}</div>
                        <div class="font-bold text-ink-900 truncate">Dr. {{ $doc->name }}</div>
                        <div class="text-sm text-ink-500 truncate">{{ $doc->years_experience }} yrs · {{ $doc->location }}</div>
                    </div>
                </div>
                <p class="mt-3 text-sm text-ink-500 line-clamp-2">{{ $doc->bio }}</p>
                <div class="mt-4 flex items-center justify-between pt-4 border-t border-gray-100">
                    <div class="flex items-center gap-1 text-amber-500 text-sm font-semibold">★ {{ $doc->rating }}</div>
                    <div class="text-sm">
                        <span class="text-ink-500">from </span>
                        <span class="font-bold text-ink-900">${{ $doc->price }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="mt-8">{{ $doctors->links() }}</div>
    @else
        <div class="card p-12 text-center">
            <div class="text-5xl">🔍</div>
            <h3 class="mt-4 text-lg font-bold text-ink-900">No doctors match your search</h3>
            <p class="mt-1 text-sm text-ink-500">Try clearing filters or searching for a different specialty.</p>
            <a href="{{ route('doctors.index') }}" class="btn-primary mt-5 inline-flex">Reset filters</a>
        </div>
    @endif
</section>
@endsection
