<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\UniversityController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UniversityController::class, 'index'])->name('university.index');
Route::get('/universities/{university}', [UniversityController::class, 'show'])->name('university.show');
Route::post('/universities/{university}/apply', [ApplicationController::class, 'store'])->name('application.store');
