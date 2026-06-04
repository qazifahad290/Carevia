<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#5B2EE6">

        <title>@yield('title', 'Carevia')</title>

        <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 40 40'%3E%3Crect width='40' height='40' rx='11' fill='%235B2EE6'/%3E%3Cpath d='M20 30.5c-.4 0-.8-.13-1.13-.4-3.06-2.46-7.62-6.5-7.62-10.85 0-3.07 2.43-5.5 5.5-5.5 1.7 0 3.27.78 4.25 2 .98-1.22 2.55-2 4.25-2 3.07 0 5.5 2.43 5.5 5.5 0 4.35-4.56 8.39-7.62 10.85-.33.27-.73.4-1.13.4Z' fill='white'/%3E%3Crect x='18.4' y='17.5' width='3.2' height='8' rx='1' fill='%235B2EE6'/%3E%3Crect x='16' y='19.9' width='8' height='3.2' rx='1' fill='%235B2EE6'/%3E%3C/svg%3E">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen flex flex-col">
        <div class="flex-1 flex">
            <div class="hidden lg:flex w-1/2 bg-gradient-to-br from-primary-500 to-primary-700 text-white p-12 flex-col justify-between relative overflow-hidden">
                <div class="absolute -top-32 -right-32 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>

                <a href="{{ route('home') }}" class="flex items-center gap-2 relative z-10">
                    <x-brand-logo class="h-9 text-white" />
                </a>

                <div class="relative z-10">
                    <h2 class="text-4xl font-extrabold leading-tight">Book trusted doctors in minutes.</h2>
                    <p class="mt-3 text-primary-100 max-w-md">Real availability, real reviews, real care — all in one place.</p>
                    <div class="mt-10 grid grid-cols-3 gap-4 max-w-md">
                        <div>
                            <div class="text-3xl font-extrabold">500+</div>
                            <div class="text-xs text-primary-100">Doctors</div>
                        </div>
                        <div>
                            <div class="text-3xl font-extrabold">24/7</div>
                            <div class="text-xs text-primary-100">Quick care</div>
                        </div>
                        <div>
                            <div class="text-3xl font-extrabold">4.9★</div>
                            <div class="text-xs text-primary-100">Rating</div>
                        </div>
                    </div>
                </div>

                <div class="text-xs text-primary-100 relative z-10">© {{ date('Y') }} Carevia</div>
            </div>

            <div class="w-full lg:w-1/2 flex flex-col p-6 sm:p-12">
                <a href="{{ route('home') }}" class="lg:hidden mb-8">
                    <x-brand-logo class="h-9" />
                </a>
                <div class="flex-1 flex items-center justify-center">
                    <div class="w-full max-w-md">
                        {{ $slot ?? '' }}
                        @yield('auth-content')
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
