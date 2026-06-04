<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\QuickCareRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $upcoming = Appointment::with('doctor.specialty')
            ->where('patient_id', $user->id)
            ->where('date', '>=', now()->toDateString())
            ->where('status', 'confirmed')
            ->orderBy('date')->orderBy('time')
            ->get();

        $past = Appointment::with('doctor.specialty')
            ->where('patient_id', $user->id)
            ->where(function ($q) {
                $q->where('date', '<', now()->toDateString())
                  ->orWhereIn('status', ['cancelled', 'completed']);
            })
            ->orderByDesc('date')->orderByDesc('time')
            ->limit(20)->get();

        $quickCareRequests = QuickCareRequest::with('specialty')
            ->where('patient_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        return view('appointments.index', compact('upcoming', 'past', 'quickCareRequests'));
    }

    public function cancel(Request $request, Appointment $appointment): RedirectResponse
    {
        abort_unless($appointment->patient_id === $request->user()->id, 403);
        $appointment->update(['status' => 'cancelled']);
        return back()->with('status', 'Appointment cancelled.');
    }
}
