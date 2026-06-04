<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $specialties = Specialty::withCount('doctors')->get();
        $topDoctors  = Doctor::with('specialty')
            ->where('is_active', true)
            ->orderByDesc('rating')
            ->take(6)
            ->get();
        $todays = Appointment::with('doctor.specialty')
            ->where('patient_id', auth()->id())
            ->where('date', '>=', now()->toDateString())
            ->where('status', 'confirmed')
            ->orderBy('date')->orderBy('time')
            ->take(3)
            ->get();

        return view('dashboard', compact('specialties', 'topDoctors', 'todays'));
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
