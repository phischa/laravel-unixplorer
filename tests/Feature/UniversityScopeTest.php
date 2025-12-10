<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\University;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UniversityScopeTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_scope_filters_by_name(): void
    {
        University::factory()->create(['name' => 'Hamburg University']);
        University::factory()->create(['name' => 'Berlin University']);
        University::factory()->create(['name' => 'Munich University']);

        $results = University::search('Hamburg')->get();

        $this->assertCount(1, $results);
        $this->assertEquals('Hamburg University', $results->first()->name);
    }

    public function test_search_scope_returns_all_when_null(): void
    {
        University::factory()->count(3)->create();

        $results = University::search(null)->get();

        $this->assertCount(3, $results);
    }

    public function test_filter_by_course_scope(): void
    {
        $uni1 = University::factory()->create(['name' => 'Uni A']);
        $uni2 = University::factory()->create(['name' => 'Uni B']);

        $course = Course::create([
            'name' => 'Computer Science',
            'category' => 'Technology',
            'rating' => 4,
        ]);

        $uni1->courses()->attach($course);

        $results = University::filterByCourse($course->id)->get();

        $this->assertCount(1, $results);
        $this->assertEquals('Uni A', $results->first()->name);
    }

    public function test_filter_by_course_returns_all_when_null(): void
    {
        University::factory()->count(3)->create();

        $results = University::filterByCourse(null)->get();

        $this->assertCount(3, $results);
    }

    public function test_min_rating_scope_filters_universities(): void
    {
        $uni1 = University::factory()->create(['name' => 'High Rated']);
        $uni2 = University::factory()->create(['name' => 'Low Rated']);

        $highRatedCourse = Course::create([
            'name' => 'Good Course',
            'category' => 'Science',
            'rating' => 5,
        ]);

        $lowRatedCourse = Course::create([
            'name' => 'Bad Course',
            'category' => 'Science',
            'rating' => 2,
        ]);

        $uni1->courses()->attach($highRatedCourse);
        $uni2->courses()->attach($lowRatedCourse);

        $results = University::minRating(true)->get();

        $this->assertCount(1, $results);
        $this->assertEquals('High Rated', $results->first()->name);
    }

    public function test_min_rating_returns_all_when_false(): void
    {
        University::factory()->count(3)->create();

        $results = University::minRating(false)->get();

        $this->assertCount(3, $results);
    }
}
