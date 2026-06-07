@extends('layouts.app')
@section('title', 'Admin overview — Carevia')

@section('content')
<section class="bg-gradient-to-br from-rose-50 to-surface-100 border-b border-rose-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <span class="chip bg-white text-rose-700">⚙️ Admin console</span>
        <h1 class="mt-3 text-3xl lg:text-4xl font-extrabold text-ink-900">System overview</h1>
        <p class="mt-1 text-ink-500">All appointments, doctors, patients, and providers in one place.</p>

        <div class="mt-6 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
            <div class="card p-4">
                <div class="text-xs font-semibold uppercase tracking-wider text-ink-500">Patients</div>
                <div class="mt-1 text-2xl font-extrabold text-ink-900">{{ $userStats['patients'] }}</div>
            </div>
            <div class="card p-4">
                <div class="text-xs font-semibold uppercase tracking-wider text-ink-500">Providers</div>
                <div class="mt-1 text-2xl font-extrabold text-ink-900">{{ $userStats['doctors'] }}</div>
            </div>
            <div class="card p-4">
                <div class="text-xs font-semibold uppercase tracking-wider text-ink-500">Doctors listed</div>
                <div class="mt-1 text-2xl font-extrabold text-ink-900">{{ $doctorCount }}</div>
            </div>
            <div class="card p-4">
                <div class="text-xs font-semibold uppercase tracking-wider text-ink-500">Specialties</div>
                <div class="mt-1 text-2xl font-extrabold text-ink-900">{{ $specialtyCount }}</div>
            </div>
            <div class="card p-4">
                <div class="text-xs font-semibold uppercase tracking-wider text-ink-500">Total users</div>
                <div class="mt-1 text-2xl font-extrabold text-ink-900">{{ $userStats['total'] }}</div>
            </div>
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h2 class="text-2xl font-extrabold text-ink-900 mb-5">Appointments</h2>
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
        <div class="card p-4 border-l-4 border-primary-500">
            <div class="text-xs font-semibold uppercase tracking-wider text-ink-500">Total</div>
            <div class="mt-1 text-2xl font-extrabold text-ink-900">{{ $apptStats['total'] }}</div>
        </div>
        <div class="card p-4 border-l-4 border-amber-500">
            <div class="text-xs font-semibold uppercase tracking-wider text-ink-500">Today</div>
            <div class="mt-1 text-2xl font-extrabold text-ink-900">{{ $apptStats['today'] }}</div>
        </div>
        <div class="card p-4 border-l-4 border-blue-500">
            <div class="text-xs font-semibold uppercase tracking-wider text-ink-500">Confirmed</div>
            <div class="mt-1 text-2xl font-extrabold text-ink-900">{{ $apptStats['confirmed'] }}</div>
        </div>
        <div class="card p-4 border-l-4 border-green-500">
            <div class="text-xs font-semibold uppercase tracking-wider text-ink-500">Completed</div>
            <div class="mt-1 text-2xl font-extrabold text-green-600">{{ $apptStats['completed'] }}</div>
        </div>
        <div class="card p-4 border-l-4 border-red-500">
            <div class="text-xs font-semibold uppercase tracking-wider text-ink-500">Cancelled</div>
            <div class="mt-1 text-2xl font-extrabold text-red-500">{{ $apptStats['cancelled'] }}</div>
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10">
    <div class="grid lg:grid-cols-2 gap-6">
        <div>
            <h2 class="text-xl font-extrabold text-ink-900 mb-4">Recent appointments</h2>
            <div class="card overflow-hidden">
                @forelse($recentAppointments as $appt)
                    <div class="px-5 py-3 border-b border-gray-100 last:border-0 flex items-center gap-3">
                        <img src="{{ $appt->patient->avatarUrl() }}" class="w-9 h-9 rounded-full object-cover" alt="">
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-semibold text-ink-900 truncate">{{ $appt->patient->name }} → Dr. {{ $appt->doctor->name }}</div>
                            <div class="text-xs text-ink-500">{{ $appt->date->format('M d') }} · {{ \Carbon\Carbon::parse($appt->time)->format('g:i A') }} · {{ $appt->doctor->specialty->name }}</div>
                        </div>
                        <span class="chip {{ $appt->status === 'confirmed' ? 'bg-green-50 text-green-700' : ($appt->status === 'cancelled' ? 'bg-red-50 text-red-700' : 'bg-gray-100 text-ink-500') }}">{{ ucfirst($appt->status) }}</span>
                    </div>
                @empty
                    <div class="p-8 text-center text-sm text-ink-500">No appointments yet.</div>
                @endforelse
            </div>
        </div>

        <div>
            <h2 class="text-xl font-extrabold text-ink-900 mb-4">Top providers (by appointments)</h2>
            <div class="card overflow-hidden">
                @forelse($topDoctors as $doc)
                    <div class="px-5 py-3 border-b border-gray-100 last:border-0 flex items-center gap-3">
                        <img src="{{ $doc->photoUrl() }}" class="w-9 h-9 rounded-full object-cover" alt="">
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-semibold text-ink-900 truncate">Dr. {{ $doc->name }}</div>
                            <div class="text-xs text-ink-500">{{ $doc->specialty->name }} · ★ {{ $doc->rating }}</div>
                        </div>
                        <span class="text-sm font-bold text-ink-900">{{ $doc->appointments_count }}</span>
                    </div>
                @empty
                    <div class="p-8 text-center text-sm text-ink-500">No providers yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    <h2 class="text-xl font-extrabold text-ink-900 mb-4">Recent users</h2>
    <div class="card overflow-hidden">
        <table class="w-full">
            <thead class="bg-surface-50 border-b border-gray-100">
                <tr>
                    <th class="text-left text-xs font-semibold uppercase tracking-wider text-ink-500 px-5 py-3">Name</th>
                    <th class="text-left text-xs font-semibold uppercase tracking-wider text-ink-500 px-5 py-3">Email</th>
                    <th class="text-left text-xs font-semibold uppercase tracking-wider text-ink-500 px-5 py-3">Role</th>
                    <th class="text-left text-xs font-semibold uppercase tracking-wider text-ink-500 px-5 py-3">Joined</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($recentUsers as $u)
                    <tr>
                        <td class="px-5 py-3 text-sm font-semibold text-ink-900">{{ $u->name }}</td>
                        <td class="px-5 py-3 text-sm text-ink-500">{{ $u->email }}</td>
                        <td class="px-5 py-3">
                            <span class="chip {{ $u->role === 'doctor' ? 'bg-amber-50 text-amber-700' : ($u->role === 'admin' ? 'bg-rose-50 text-rose-700' : 'bg-primary-50 text-primary-700') }}">{{ ucfirst($u->role) }}</span>
                        </td>
                        <td class="px-5 py-3 text-sm text-ink-500">{{ $u->created_at->format('M d, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
