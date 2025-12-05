<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UniversityController extends Controller
{
    /**
     * Display a paginated list of universities sorted by average course rating.
     */
    public function index(Request $request): Response
    {
        $universities = University::withCount('courses')
        > withAvg('courses', 'rating')
            ->search($request->search)
            ->filterByCourse($request->course)
            ->minRating($request->boolean('rating'))
            ->orderByDesc('courses_avg_rating')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Universities/Index', [
            'universities' => $universities,
            'courses' => Course::orderBy('name')->get(),
            'filters' => $request->only(['search', 'course', 'rating']),
        ]);
    }

    public function show(University $university)
    {
        return Inertia::render('Universities/Show', [
            'university' => $university,
        ]);
    }
}
