<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\University;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Store a new application for a university.
     */
    public function store(Request $request, University $university): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email',
        ]);

        // Check: Cannot apply twice to same university with same email
        $existingApplication = Application::where('university_is', $university->id)
            ->where('email', $validated['email'])
            ->exists();

        if ($existingApplication) {
            return back()->withErrors([
                'email' => 'You have already applied to this university.',
            ]);
        }

        // Check: Cannot apply to more than 3 universities per day
        $applicationsToday = Application::where('email', $validated['email'])
            ->whereDate('created_at', today())
            ->count();

        if ($applicationsToday >= 3) {
            return back()->withErrors([
                'email' => 'You can only apply to 3 universities per day.',
            ]);
        }

        // Create the application
        Application::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'university_id' => $university->id,
        ]);

        return back()->with('success', 'Application submitted successfully!');
    }
}
