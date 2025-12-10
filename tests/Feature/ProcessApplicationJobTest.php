<?php

namespace Tests\Feature;

use App\Jobs\ProcessApplication;
use App\Mail\ApplicationResultMail;
use App\Models\Application;
use App\Models\University;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ProcessApplicationJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_updates_application_status(): void
    {
        Mail::fake();

        $university = University::factory()->create();
        $application = Application::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'university_id' => $university->id,
        ]);

        $this->assertNull($application->status);

        $job = new ProcessApplication($application);
        $job->handle();

        $application->refresh();
        $this->assertContains($application->status, ['accepted', 'rejected']);
    }

    public function test_job_sends_email_to_applicant(): void
    {
        Mail::fake();

        $university = University::factory()->create();
        $application = Application::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'university_id' => $university->id,
        ]);

        $job = new ProcessApplication($application);
        $job->handle();

        Mail::assertSent(ApplicationResultMail::class, function ($mail) {
            return $mail->hasTo('john@example.com');
        });
    }

    public function test_job_is_dispatched_with_delay(): void
    {
        \Illuminate\Support\Facades\Queue::fake();

        $university = University::factory()->create();

        $response = $this->post("/universities/{$university->id}/apply", [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $response->assertRedirect();

        \Illuminate\Support\Facades\Queue::assertPushed(ProcessApplication::class, function ($job) {
            return $job->delay !== null;
        });
    }
}
