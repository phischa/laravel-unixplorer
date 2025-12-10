<?php

namespace Tests\Unit;

use App\Models\Application;
use App\Models\University;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplicationModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_application_belongs_to_university(): void
    {
        $university = University::factory()->create(['name' => 'Test University']);

        $application = Application::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'university_id' => $university->id,
        ]);

        $this->assertEquals('Test University', $application->university->name);
    }

    public function test_application_has_fillable_attributes(): void
    {
        $university = University::factory()->create();

        $application = Application::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'university_id' => $university->id,
            'status' => 'accepted',
        ]);

        $this->assertEquals('Jane Doe', $application->name);
        $this->assertEquals('jane@example.com', $application->email);
        $this->assertEquals('accepted', $application->status);
    }

    public function test_application_status_can_be_null(): void
    {
        $university = University::factory()->create();

        $application = Application::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'university_id' => $university->id,
        ]);

        $this->assertNull($application->status);
    }

    public function test_application_status_can_be_accepted(): void
    {
        $university = University::factory()->create();

        $application = Application::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'university_id' => $university->id,
            'status' => 'accepted',
        ]);

        $this->assertEquals('accepted', $application->status);
    }

    public function test_application_status_can_be_rejected(): void
    {
        $university = University::factory()->create();

        $application = Application::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'university_id' => $university->id,
            'status' => 'rejected',
        ]);

        $this->assertEquals('rejected', $application->status);
    }
}
