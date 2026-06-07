<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $doctor = $request->user()->doctorProfile()->with('specialty')->firstOrFail();

        $today = Appointment::with('patient')
            ->forDoctor($doctor->id)
            ->today()
            ->whereIn('status', ['confirmed'])
            ->orderBy('time')
            ->get();

        $upcoming = Appointment::with('patient')
            ->forDoctor($doctor->id)
            ->upcoming()
            ->where('date', '>', now()->toDateString())
            ->limit(20)
            ->get();

        $recent = Appointment::with('patient')
            ->forDoctor($doctor->id)
            ->past()
            ->limit(10)
            ->get();

        $stats = [
            'today'      => $today->count(),
            'upcoming'   => $upcoming->count(),
            'completed'  => Appointment::forDoctor($doctor->id)->where('status', 'completed')->count(),
            'cancelled'  => Appointment::forDoctor($doctor->id)->where('status', 'cancelled')->count(),
        ];

        return view('doctor.dashboard', compact('doctor', 'today', 'upcoming', 'recent', 'stats'));
    }

    public function complete(Request $request, Appointment $appointment): RedirectResponse
    {
        $doctor = $request->user()->doctorProfile;
        abort_unless($doctor && $appointment->doctor_id === $doctor->id, 403);
        abort_unless(in_array($appointment->status, ['confirmed'], true), 422, 'Appointment cannot be marked complete.');

        $appointment->update(['status' => 'completed']);
        return back()->with('status', 'Appointment marked as completed.');
    }

    public function cancel(Request $request, Appointment $appointment): RedirectResponse
    {
        $doctor = $request->user()->doctorProfile;
        abort_unless($doctor && $appointment->doctor_id === $doctor->id, 403);
        abort_unless(in_array($appointment->status, ['confirmed'], true), 422, 'Only confirmed appointments can be cancelled.');

        $appointment->update(['status' => 'cancelled']);
        return back()->with('status', 'Appointment cancelled.');
    }
}
