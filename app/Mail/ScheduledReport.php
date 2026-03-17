<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ScheduledReport extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this->subject('Scheduled Report')
                    ->view('emails.scheduled_report')
                    ->with(['time' => now()]);
    }
}