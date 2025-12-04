<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UniversityController extends Controller
{   
    /**
     * Display a paginated list of universities sorted by average course rating.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {   
        $universities = University::withCount('cources')
            ->withAvg('courses', 'rating')
            ->orderByDesc('courses_avg_rating')
            ->paginate(10);
        return Inertia::render('Universities/Index',[
            'universities' => University::all(),
        ]);
    }

    public function show(University $university)
    {
        return Inertia::render('Universities/Show', [
            'university' => $university,
        ]);
    }
}
