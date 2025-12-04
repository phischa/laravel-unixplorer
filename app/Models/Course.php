<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the universities that offer this course.
     */
    public function universities()
    {
        return $this->belongsToMany(University::class);
    }
}
