<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\University;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UniversityControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_page_displays_universities(): void
    {
        University::factory()->count(3)->create();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Universities/Index')
            ->has('universities.data', 3)
        );
    }

    public function test_index_page_paginates_results(): void
    {
        University::factory()->count(15)->create();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Universities/Index')
            ->where('universities.total', 15)
            ->has('universities.links')
        );
    }

    public function test_index_page_includes_courses_for_filter(): void
    {
        Course::create(['name' => 'Computer Science', 'category' => 'Tech', 'rating' => 4]);
        Course::create(['name' => 'Mathematics', 'category' => 'Science', 'rating' => 5]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->has('courses', 2)
        );
    }

    public function test_index_filters_by_search(): void
    {
        University::factory()->create(['name' => 'Hamburg University']);
        University::factory()->create(['name' => 'Berlin University']);

        $response = $this->get('/?search=Hamburg');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->has('universities.data', 1)
            ->where('universities.data.0.name', 'Hamburg University')
        );
    }

    public function test_index_filters_by_course(): void
    {
        $uni1 = University::factory()->create(['name' => 'Uni A']);
        $uni2 = University::factory()->create(['name' => 'Uni B']);

        $course = Course::create(['name' => 'Physics', 'category' => 'Science', 'rating' => 4]);
        $uni1->courses()->attach($course);

        $response = $this->get("/?course={$course->id}");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->has('universities.data', 1)
            ->where('universities.data.0.name', 'Uni A')
        );
    }

    public function test_show_page_displays_university_details(): void
    {
        $university = University::factory()->create(['name' => 'Test University']);

        $response = $this->get("/universities/{$university->id}");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Universities/Show')
            ->where('university.name', 'Test University')
        );
    }

    public function test_show_page_includes_courses(): void
    {
        $university = University::factory()->create();
        $course = Course::create(['name' => 'Biology', 'category' => 'Science', 'rating' => 4]);
        $university->courses()->attach($course);

        $response = $this->get("/universities/{$university->id}");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->has('university.courses', 1)
            ->where('university.courses.0.name', 'Biology')
        );
    }

    public function test_show_page_returns_404_for_invalid_university(): void
    {
        $response = $this->get('/universities/999');

        $response->assertStatus(404);
    }
}
