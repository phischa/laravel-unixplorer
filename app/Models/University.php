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
     */
    public function scopeMinRating(Builder $query, bool $apply = false): Builder
    {
        return $query->when($apply, function ($query) {
            $query->having('courses_avg_rating', '>=', 4);
        });
    }
}
