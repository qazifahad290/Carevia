<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#5B2EE6">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <title>@yield('title', 'Carevia — Book your doctor')</title>

    <link rel="manifest" href="/manifest.json">
    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 40 40'%3E%3Crect width='40' height='40' rx='11' fill='%235B2EE6'/%3E%3Cpath d='M20 30.5c-.4 0-.8-.13-1.13-.4-3.06-2.46-7.62-6.5-7.62-10.85 0-3.07 2.43-5.5 5.5-5.5 1.7 0 3.27.78 4.25 2 .98-1.22 2.55-2 4.25-2 3.07 0 5.5 2.43 5.5 5.5 0 4.35-4.56 8.39-7.62 10.85-.33.27-.73.4-1.13.4Z' fill='white'/%3E%3Crect x='18.4' y='17.5' width='3.2' height='8' rx='1' fill='%235B2EE6'/%3E%3Crect x='16' y='19.9' width='8' height='3.2' rx='1' fill='%235B2EE6'/%3E%3C/svg%3E">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-surface-50">
    @include('layouts.navigation')

    <main class="flex-1 pb-20">
        @yield('content')
    </main>

    @auth
        @php
            $tab = 'home';
            if (request()->routeIs('doctors.*')) $tab = 'doctors';
            elseif (request()->routeIs('appointments.*')) $tab = 'appointments';
            elseif (request()->routeIs('profile.*')) $tab = 'profile';
        @endphp
        <x-bottom-nav :active="$tab" />
    @endauth
</body>
</html>
