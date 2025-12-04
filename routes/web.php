<?php

use App\Http\Controllers\UniversityController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [UniversityController::class, 'index'])->name('university.index');
Route::get('/universities/{university}', [UniversityController::class, 'show'])->name('university.show');
