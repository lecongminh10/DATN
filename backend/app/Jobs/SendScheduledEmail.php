<?php

namespace App\Jobs;

use App\Mail\CustomEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendScheduledEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $toEmail;
    public $subject;
    public $message;
    public $scheduleDate;

    /**
     * Create a new job instance.
     */
    public function __construct($toEmail, $subject, $message, $scheduleDate)
    {
        $this->toEmail = $toEmail;
        $this->subject = $subject;
        $this->message = $message;
        $this->scheduleDate = Carbon::parse($scheduleDate);
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        foreach ($this->toEmail as $email) {
            Mail::send(new CustomEmail($this->subject, $this->message, $email));
        }
    }
}
