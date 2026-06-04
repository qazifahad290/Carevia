<?php

namespace App\Http\Controllers;

use App\Models\QuickCareRequest;
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
            'reason'       => 'required|string|min:10|max:1000',
            'urgency'      => 'required|in:low,normal,high',
        ]);

        QuickCareRequest::create([
            'patient_id'   => $request->user()->id,
            'specialty_id' => $data['specialty_id'],
            'reason'       => $data['reason'],
            'urgency'      => $data['urgency'],
            'status'       => 'pending',
        ]);

        return redirect()->route('appointments.index')->with('status', 'Quick care request submitted. A specialist will be matched shortly.');
    }
}
