<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $specialties = Specialty::withCount('doctors')->get();
        $topDoctors  = Doctor::with('specialty')
            ->where('is_active', true)
            ->orderByDesc('rating')
            ->take(6)
            ->get();

        $todays = Appointment::with('doctor.specialty')
            ->where('patient_id', $user->id)
            ->where('date', '>=', now()->toDateString())
            ->where('status', 'confirmed')
            ->orderBy('date')->orderBy('time')
            ->take(3)
            ->get();

        $stats = [
            'upcoming'  => Appointment::where('patient_id', $user->id)->where('date', '>=', now()->toDateString())->where('status', 'confirmed')->count(),
            'completed' => Appointment::where('patient_id', $user->id)->where('status', 'completed')->count(),
            'cancelled' => Appointment::where('patient_id', $user->id)->where('status', 'cancelled')->count(),
            'total'     => Appointment::where('patient_id', $user->id)->count(),
        ];

        return view('dashboard', compact('specialties', 'topDoctors', 'todays', 'stats'));
    }

    public function welcome(): View
    {
        $featured = Doctor::with('specialty')
            ->where('is_active', true)
            ->orderByDesc('rating')
            ->take(3)
            ->get();

        return view('welcome', compact('featured'));
    }
}
