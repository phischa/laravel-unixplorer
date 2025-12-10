<?php

namespace Tests\Unit;

use App\Models\Application;
use App\Models\Course;
use App\Models\University;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UniversityModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_university_has_many_applications(): void
    {
        $university = University::factory()->create();

        Application::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'university_id' => $university->id,
        ]);

        Application::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'university_id' => $university->id,
        ]);

        $this->assertCount(2, $university->applications);
    }

    public function test_university_belongs_to_many_courses(): void
    {
        $university = University::factory()->create();

        $course1 = Course::create(['name' => 'Physics', 'category' => 'Science', 'rating' => 4]);
        $course2 = Course::create(['name' => 'Math', 'category' => 'Science', 'rating' => 5]);

        $university->courses()->attach([$course1->id, $course2->id]);

        $this->assertCount(2, $university->courses);
    }

    public function test_homepage_accessor_converts_http_to_https(): void
    {
        $university = University::factory()->create([
            'homepage' => 'http://www.example.com',
        ]);

        $this->assertEquals('https://www.example.com', $university->homepage);
    }

    public function test_homepage_accessor_keeps_https_unchanged(): void
    {
        $university = University::factory()->create([
            'homepage' => 'https://www.example.com',
        ]);

        $this->assertEquals('https://www.example.com', $university->homepage);
    }

    public function test_homepage_accessor_handles_null(): void
    {
        $university = University::factory()->create([
            'homepage' => null,
        ]);

        $this->assertNull($university->homepage);
    }
}
