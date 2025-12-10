<?php

namespace Tests\Unit;

use App\Models\Course;
use App\Models\University;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_course_belongs_to_many_universities(): void
    {
        $course = Course::create([
            'name' => 'Computer Science',
            'category' => 'Technology',
            'rating' => 5,
        ]);

        $uni1 = University::factory()->create(['name' => 'Uni A']);
        $uni2 = University::factory()->create(['name' => 'Uni B']);

        $course->universities()->attach([$uni1->id, $uni2->id]);

        $this->assertCount(2, $course->universities);
    }

    public function test_course_has_name_attribute(): void
    {
        $course = Course::create([
            'name' => 'Mathematics',
            'category' => 'Science',
            'rating' => 4,
        ]);

        $this->assertEquals('Mathematics', $course->name);
    }

    public function test_course_has_category_attribute(): void
    {
        $course = Course::create([
            'name' => 'Physics',
            'category' => 'Science',
            'rating' => 4,
        ]);

        $this->assertEquals('Science', $course->category);
    }

    public function test_course_has_rating_attribute(): void
    {
        $course = Course::create([
            'name' => 'Chemistry',
            'category' => 'Science',
            'rating' => 3,
        ]);

        $this->assertEquals(3, $course->rating);
    }

    public function test_course_category_can_be_null(): void
    {
        $course = Course::create([
            'name' => 'Art',
            'category' => null,
            'rating' => 4,
        ]);

        $this->assertNull($course->category);
    }
}
