<nav x-data="{ open: false }" class="bg-white/90 backdrop-blur border-b border-gray-100 sticky top-0 z-30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-10">
                <a href="{{ route('home') }}" class="block">
                    <x-brand-logo class="h-9" />
                </a>
                @auth
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'nav-link-active' : '' }}">Home</a>
                    <a href="{{ route('doctors.index') }}" class="nav-link {{ request()->routeIs('doctors.*') ? 'nav-link-active' : '' }}">Find Doctors</a>
                    <a href="{{ route('appointments.index') }}" class="nav-link {{ request()->routeIs('appointments.*') ? 'nav-link-active' : '' }}">Appointments</a>
                    <a href="{{ route('quick-care.create') }}" class="nav-link {{ request()->routeIs('quick-care.*') ? 'nav-link-active' : '' }}">Quick Care</a>
                </div>
                @endauth
            </div>

            <div class="hidden md:flex items-center gap-3">
                @auth
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-full hover:bg-surface-100 transition">
                        <img src="{{ auth()->user()->avatarUrl() }}" alt="" class="w-8 h-8 rounded-full object-cover">
                        <span class="text-sm font-semibold text-ink-900">{{ auth()->user()->name }}</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-secondary !py-1.5 !px-4 !text-xs">Log out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-ghost">Log in</a>
                    <a href="{{ route('register') }}" class="btn-primary !py-1.5 !px-4">Sign up</a>
                @endauth
            </div>

            <div class="md:hidden flex items-center">
                <button @click="open = !open" class="p-2 rounded-lg text-ink-700 hover:bg-surface-100">
                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open" x-transition class="md:hidden border-t border-gray-100 bg-white">
        <div class="px-4 py-3 space-y-1">
            @auth
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-700' : 'text-ink-700 hover:bg-surface-100' }}">Home</a>
                <a href="{{ route('doctors.index') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('doctors.*') ? 'bg-primary-50 text-primary-700' : 'text-ink-700 hover:bg-surface-100' }}">Find Doctors</a>
                <a href="{{ route('appointments.index') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('appointments.*') ? 'bg-primary-50 text-primary-700' : 'text-ink-700 hover:bg-surface-100' }}">Appointments</a>
                <a href="{{ route('quick-care.create') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('quick-care.*') ? 'bg-primary-50 text-primary-700' : 'text-ink-700 hover:bg-surface-100' }}">Quick Care</a>
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-ink-700 hover:bg-surface-100">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-sm font-semibold text-ink-700 hover:bg-surface-100">Log out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-ink-700 hover:bg-surface-100">Log in</a>
                <a href="{{ route('register') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-primary-700 hover:bg-surface-100">Sign up</a>
            @endauth
        </div>
    </div>
</nav>
