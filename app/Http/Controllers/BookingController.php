<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function create(Doctor $doctor): View
    {
        $doctor->load('schedules', 'specialty');
        $nextDays = collect();
        for ($i = 0; $i < 14; $i++) {
            $nextDays->push(Carbon::today()->addDays($i));
        }
        return view('booking.create', compact('doctor', 'nextDays'));
    }

    public function slots(Doctor $doctor, Request $request)
    {
        $request->validate(['date' => 'required|date|after_or_equal:today']);

        $date    = Carbon::parse($request->input('date'));
        $dayOfWeek = $date->dayOfWeekIso;

        $schedule = DoctorSchedule::where('doctor_id', $doctor->id)
            ->where('day_of_week', $dayOfWeek)
            ->first();

        if (!$schedule) {
            return response()->json(['slots' => [], 'message' => 'Doctor not available this day.']);
        }

        $booked = Appointment::where('doctor_id', $doctor->id)
            ->where('date', $date->toDateString())
            ->whereIn('status', ['confirmed', 'completed'])
            ->pluck('time')
            ->map(fn ($t) => Carbon::parse($t)->format('H:i'))
            ->toArray();

        $slots = [];
        $cursor = Carbon::parse($date->toDateString() . ' ' . $schedule->start_time);
        $end    = Carbon::parse($date->toDateString() . ' ' . $schedule->end_time);
        $now    = Carbon::now();

        while ($cursor->lt($end)) {
            $time = $cursor->format('H:i');
            if (!in_array($time, $booked, true) && $cursor->gt($now)) {
                $slots[] = $time;
            }
            $cursor->addMinutes($schedule->slot_minutes);
        }

        return response()->json(['slots' => $slots]);
    }

    public function store(Doctor $doctor, Request $request): RedirectResponse
    {
        $data = $request->validate([
            'date'  => 'required|date|after_or_equal:today',
            'time'  => 'required|date_format:H:i',
            'notes' => 'nullable|string|max:500',
        ]);

        $exists = Appointment::where('doctor_id', $doctor->id)
            ->where('date', $data['date'])
            ->where('time', $data['time'])
            ->whereIn('status', ['confirmed', 'completed'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['time' => 'This slot was just taken. Please pick another.'])->withInput();
        }

        try {
            $appointment = Appointment::create([
                'patient_id' => $request->user()->id,
                'doctor_id'  => $doctor->id,
                'date'       => $data['date'],
                'time'       => $data['time'],
                'notes'      => $data['notes'] ?? null,
                'status'     => 'confirmed',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withErrors(['time' => 'This slot was just taken. Please pick another.'])->withInput();
        }

        return redirect()->route('appointments.success', $appointment);
    }

    public function success(Appointment $appointment): View
    {
        abort_unless($appointment->patient_id === auth()->id(), 403);
        $appointment->load('doctor.specialty');
        return view('booking.success', compact('appointment'));
    }

    public function payment(Appointment $appointment): View
    {
        abort_unless($appointment->patient_id === auth()->id(), 403);
        $appointment->load('doctor.specialty');
        return view('booking.payment', compact('appointment'));
    }

    public function processPayment(Appointment $appointment, Request $request): RedirectResponse
    {
        abort_unless($appointment->patient_id === auth()->id(), 403);

        $request->validate([
            'card_number' => 'required|string|size:19',
            'expiry'      => 'required|string',
            'cvv'         => 'required|string|size:3',
            'name'        => 'required|string|max:255',
        ]);

        $appointment->update([
            'notes' => ($appointment->notes ? $appointment->notes . "\n---\n" : '') . 'Payment completed on ' . now()->format('M d, Y g:i A'),
        ]);

        return redirect()->route('appointments.success', $appointment)
            ->with('status', 'Payment successful! Your appointment is confirmed.');
    }
}
