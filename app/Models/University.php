<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    /**
     * Get the applications for this university.
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Scope: Search universities by name.
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%");
        });
    }

    /**
     * Scope: Filter universities that offer a specific course.
     */
    public function scopeFilterByCourse(Builder $query, ?int $courseId): Builder
    {
        return $query->when($courseId, function ($query, $courseId) {
            $query->whereHas('courses', function ($courseQuery) use ($courseId) {
                $courseQuery->where('courses.id', $courseId);
            });
        });
    }

    /**
     * Scope: Filter universities with minimum average rating of 4.
     *
     * Uses raw SQL subquery instead of HAVING clause because SQLite
     * does not support HAVING on non-aggregated queries. The withAvg()
     * method creates a subquery, not a true aggregate, so we must
     * calculate the average inline with a WHERE subquery.
     */
    public function scopeMinRating(Builder $query, bool $apply = false): Builder
    {
        return $query->when($apply, function ($query) {
            $query->whereRaw('
            (SELECT AVG(courses.rating) 
             FROM courses 
             INNER JOIN course_university ON courses.id = course_university.course_id 
             WHERE universities.id = course_university.university_id) >= 4
        ');
        });
    }
}
