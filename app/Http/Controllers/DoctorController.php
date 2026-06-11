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

        $reviews = collect([
            (object)['name' => 'Sarah M.', 'avatar' => 1, 'rating' => 5, 'date' => '2 days ago', 'text' => 'Dr. ' . $doctor->name . ' was incredibly thorough. Took the time to explain everything clearly.'],
            (object)['name' => 'James K.', 'avatar' => 2, 'rating' => 5, 'date' => '1 week ago', 'text' => 'Very professional and caring. Highly recommend.' ],
            (object)['name' => 'Emily R.', 'avatar' => 3, 'rating' => 4, 'date' => '2 weeks ago', 'text' => 'Great experience overall. Wait time was minimal.' ],
            (object)['name' => 'David L.', 'avatar' => 4, 'rating' => 5, 'date' => '3 weeks ago', 'text' => 'Best doctor I\'ve visited in years. Knowledgeable and kind.' ],
            (object)['name' => 'Anna P.', 'avatar' => 5, 'rating' => 4, 'date' => '1 month ago', 'text' => 'Clean clinic, friendly staff, and excellent care.' ],
        ]);

        return view('doctors.show', compact('doctor', 'reviews'));
    }
}
