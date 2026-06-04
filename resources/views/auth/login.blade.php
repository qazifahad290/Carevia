<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h1 class="text-2xl font-extrabold text-ink-900">Welcome back</h1>
    <p class="text-sm text-ink-500 mt-1">Log in to manage your appointments.</p>

    <form method="POST" action="{{ route('login') }}" class="mt-7 space-y-4">
        @csrf
        <div>
            <label class="text-sm font-semibold text-ink-900">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="input mt-1.5">
            @error('email')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="text-sm font-semibold text-ink-900">Password</label>
            <input id="password" type="password" name="password" required class="input mt-1.5">
            @error('password')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-primary-500 focus:ring-primary-500" name="remember">
                <span class="ms-2 text-sm text-ink-500">Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm text-primary-600 hover:text-primary-700 font-semibold" href="{{ route('password.request') }}">Forgot password?</a>
            @endif
        </div>
        <button class="btn-primary w-full !py-3">Log in</button>
    </form>

    <p class="mt-6 text-sm text-ink-500 text-center">
        Don't have an account? <a href="{{ route('register') }}" class="text-primary-600 font-semibold hover:text-primary-700">Sign up</a>
    </p>
</x-guest-layout>
