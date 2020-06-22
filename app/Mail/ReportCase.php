<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
    use Illuminate\Support\Facades\Storage;


class ReportCase extends Mailable
{
    use Queueable, SerializesModels;

    public $report;
    public $imageUrl;
    public $videoUrl;
    public $reportUrl;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($report, $imageUrl, $videoUrl, $reportUrl)
    {
        $this->report = $report;
        $this->imageUrl = $imageUrl;
        $this->videoUrl = $videoUrl;
        $this->reportUrl = $reportUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.report-case');                
    }
}
