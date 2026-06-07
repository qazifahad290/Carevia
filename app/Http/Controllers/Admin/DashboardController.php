<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\QuickCareRequest;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $userStats = [
            'patients' => User::where('role', User::ROLE_PATIENT)->count(),
            'doctors'  => User::where('role', User::ROLE_DOCTOR)->count(),
            'admins'   => User::where('role', User::ROLE_ADMIN)->count(),
            'total'    => User::count(),
        ];

        $apptStats = [
            'confirmed' => Appointment::where('status', 'confirmed')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
            'today'     => Appointment::where('date', now()->toDateString())->count(),
            'total'     => Appointment::count(),
        ];

        $doctorCount  = Doctor::count();
        $specialtyCount = Specialty::count();
        $quickCarePending = QuickCareRequest::where('status', 'pending')->count();

        $recentAppointments = Appointment::with(['patient', 'doctor.specialty'])
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        $recentUsers = User::orderByDesc('created_at')->limit(8)->get();

        $topDoctors = Doctor::with('specialty')
            ->withCount('appointments')
            ->orderByDesc('appointments_count')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'userStats', 'apptStats', 'doctorCount', 'specialtyCount',
            'quickCarePending', 'recentAppointments', 'recentUsers', 'topDoctors'
        ));
    }

    public function users(Request $request): View
    {
        $users = User::orderByDesc('created_at')->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function doctors(Request $request): View
    {
        $doctors = Doctor::with(['user', 'specialty'])
            ->withCount('appointments')
            ->orderBy('name')
            ->get();
        return view('admin.doctors', compact('doctors'));
    }

    public function appointments(Request $request): View
    {
        $appointments = Appointment::with(['patient', 'doctor.specialty'])
            ->orderByDesc('date')->orderByDesc('time')
            ->paginate(25);
        return view('admin.appointments', compact('appointments'));
    }
}
