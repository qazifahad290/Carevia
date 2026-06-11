<?php

namespace App\Http\Controllers;

use App\Models\Specialty;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuickCareController extends Controller
{
    public function create(): View
    {
        $specialties = Specialty::orderBy('name')->get();
        return view('quick-care.create', compact('specialties'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'specialty_id' => 'required|exists:specialties,id',
            'urgency'      => 'required|in:low,normal,urgent',
            'reason'       => 'required|string|max:1000',
        ]);

        $request->user()->quickCareRequests()->create($data);

        return redirect()->route('dashboard')->with('status', 'Quick care request submitted! We\'ll match you soon.');
    }
}
