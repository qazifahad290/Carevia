@extends('layouts.app')
@section('title', 'My profile — Carevia')

@section('content')
<section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-3xl font-extrabold text-ink-900">My profile</h1>
    <p class="mt-1 text-ink-500">Keep your info up to date so doctors can reach you.</p>

    @if(session('status') === 'profile-updated')
        <div class="mt-5 p-4 rounded-2xl bg-green-50 border border-green-200 text-sm text-green-800">Profile updated.</div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-8 card p-7 space-y-5">
        @csrf
        @method('PATCH')

        <div class="flex items-center gap-5">
            <img src="{{ $user->avatarUrl() }}" class="w-20 h-20 rounded-2xl object-cover" alt="">
            <div>
                <label class="text-sm font-semibold text-ink-900">Profile photo</label>
                <input type="file" name="avatar" accept="image/*" class="mt-2 text-sm">
                @error('avatar')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-4 pt-5 border-t border-gray-100">
            <div>
                <label class="text-sm font-semibold text-ink-900">Full name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="input mt-2" required>
                @error('name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="text-sm font-semibold text-ink-900">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="input mt-2" required>
                @error('email')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="text-sm font-semibold text-ink-900">Phone</label>
                <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="input mt-2" placeholder="+1 (555) 123-4567">
            </div>
            <div>
                <label class="text-sm font-semibold text-ink-900">Date of birth</label>
                <input type="date" name="dob" value="{{ old('dob', $user->dob?->format('Y-m-d')) }}" class="input mt-2">
            </div>
            <div class="sm:col-span-2">
                <label class="text-sm font-semibold text-ink-900">Address</label>
                <input type="text" name="address" value="{{ old('address', $user->address) }}" class="input mt-2" placeholder="Street, City, State">
            </div>
        </div>

        <div class="pt-2 flex justify-end">
            <button class="btn-primary !py-3 !px-6">Save changes</button>
        </div>
    </form>
</section>
@endsection
