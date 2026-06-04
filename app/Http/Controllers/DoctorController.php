<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoctorController extends Controller
{
    public function index(Request $request): View
    {
        $query = Doctor::with('specialty')->where('is_active', true);

        if ($request->filled('specialty')) {
            $query->where('specialty_id', $request->integer('specialty'));
        }

        if ($request->filled('q')) {
            $term = '%' . $request->input('q') . '%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)->orWhere('bio', 'like', $term);
            });
        }

        $sort = $request->input('sort', 'rating');
        match ($sort) {
            'price_asc'  => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'experience' => $query->orderByDesc('years_experience'),
            default      => $query->orderByDesc('rating'),
        };

        $doctors     = $query->paginate(9)->withQueryString();
        $specialties = Specialty::orderBy('name')->get();

        return view('doctors.index', compact('doctors', 'specialties'));
    }

    public function show(Doctor $doctor): View
    {
        $doctor->load('specialty', 'schedules');
        return view('doctors.show', compact('doctor'));
    }
}
