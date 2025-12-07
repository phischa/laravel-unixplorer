<?php

namespace App\Jobs;

use App\Mail\ApplicationResultMail;
use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcessApplication implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Application $application
    ) {}

    /**
     * Execute the job.
     *
     * Randomly accepts or rejects the application, saves the result
     * to the database, and sends an email notification to the applicant.
     */
    public function handle(): void
    {
        $status = rand(0, 1) === 1 ? 'accepted' : 'rejected';

        $this->application->update(['status' => $status]);

        Mail::to($this->application->email)->send(
            new ApplicationResultMail($this->application)
        );
    }
}
