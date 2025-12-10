<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\University;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplicationControllerTest extends TestCase
{
    use RefreshDatabase;

    private University $university;

    protected function setUp(): void
    {
        parent::setUp();
        $this->university = University::factory()->create();
    }

    public function test_can_submit_valid_application(): void
    {
        $response = $this->post("/universities/{$this->university->id}/apply", [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('applications', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'university_id' => $this->university->id,
        ]);
    }

    public function test_name_is_required(): void
    {
        $response = $this->post("/universities/{$this->university->id}/apply", [
            'name' => '',
            'email' => 'john@example.com',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_name_must_be_at_least_3_characters(): void
    {
        $response = $this->post("/universities/{$this->university->id}/apply", [
            'name' => 'Jo',
            'email' => 'john@example.com',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_email_is_required(): void
    {
        $response = $this->post("/universities/{$this->university->id}/apply", [
            'name' => 'John Doe',
            'email' => '',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_email_must_be_valid(): void
    {
        $response = $this->post("/universities/{$this->university->id}/apply", [
            'name' => 'John Doe',
            'email' => 'not-an-email',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_cannot_apply_twice_to_same_university(): void
    {
        // First application
        Application::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'university_id' => $this->university->id,
        ]);

        // Second application to same university
        $response = $this->post("/universities/{$this->university->id}/apply", [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_cannot_apply_to_more_than_3_universities_per_day(): void
    {
        // Create 3 applications to different universities
        for ($i = 0; $i < 3; $i++) {
            $uni = University::factory()->create();
            Application::create([
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'university_id' => $uni->id,
            ]);
        }

        // Try 4th application
        $response = $this->post("/universities/{$this->university->id}/apply", [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $response->assertSessionHasErrors('email');
    }
}
