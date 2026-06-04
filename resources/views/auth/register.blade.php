<x-guest-layout>
    <h1 class="text-2xl font-extrabold text-ink-900">Create your account</h1>
    <p class="text-sm text-ink-500 mt-1">Join Carevia and book your first visit today.</p>

    <form method="POST" action="{{ route('register') }}" class="mt-7 space-y-4">
        @csrf
        <div>
            <label class="text-sm font-semibold text-ink-900">Full name</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus class="input mt-1.5">
            @error('name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="text-sm font-semibold text-ink-900">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="input mt-1.5">
            @error('email')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="text-sm font-semibold text-ink-900">Password</label>
            <input type="password" name="password" required class="input mt-1.5">
            @error('password')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="text-sm font-semibold text-ink-900">Confirm password</label>
            <input type="password" name="password_confirmation" required class="input mt-1.5">
        </div>
        <button class="btn-primary w-full !py-3">Create account</button>
    </form>

    <p class="mt-6 text-sm text-ink-500 text-center">
        Already have an account? <a href="{{ route('login') }}" class="text-primary-600 font-semibold hover:text-primary-700">Log in</a>
    </p>
</x-guest-layout>
