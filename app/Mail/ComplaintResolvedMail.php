<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComplaintResolvedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $title, $createdby, $details, $resolvedby, $resolution;

    public function __construct($title, $createdby, $details, $resolvedby, $resolution)
    {
        $this->title = $title;
        $this->createdby = $createdby;
        $this->details = $details;
        $this->resolvedby = $resolvedby;
        $this->resolution = $resolution;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.notifications.complaintresolved')
        ->with(['title' => $this->title, 'createdby' => $this->createdby, 'details' => $this->details, 'resolvedby' => $this->resolvedby, 'resolution' => $this->resolution]);
    }
}
