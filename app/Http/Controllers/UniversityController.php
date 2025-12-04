<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UniversityController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Universities/Index');
    }

    public function show(University $university)
    {
        return Inertia::render('Universities/Show', [
            'university' => $university,
        ]);
    }
}
