<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    /** @use HasFactory<\Database\Factories\UniversityFactory> */
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the courses offered by this university.
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
}
