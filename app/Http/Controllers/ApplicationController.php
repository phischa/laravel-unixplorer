<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessApplication;
use App\Models\Application;
use App\Models\University;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Handles university application submissions.
 */
class ApplicationController extends Controller
{
    /**
     * Store a new application for a university.
     *
     * Validates the request, checks that the applicant hasn't already applied
     * to this university with the same email, and ensures they haven't exceeded
     * the daily limit of 3 applications. If valid, creates the application and
     * dispatches a background job to process the result after 15 seconds.
     */
    public function store(Request $request, University $university): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email',
        ]);

        // Check: Cannot apply twice to same university with same email
        $existingApplication = Application::where('university_id', $university->id)
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
        $application = Application::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'university_id' => $university->id,
        ]);

        // Dispatch job to process application with 15 second delay
        ProcessApplication::dispatch($application)->delay(now()->addSeconds(15));

        return back()->with('success', 'Application submitted successfully!');
    }
}
