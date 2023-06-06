<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InquiryTransferredmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $title, $transferredby, $createdby, $transferredto, $reason;

    public function __construct($title, $transferredby, $createdby, $transferredto, $reason)
    {
        $this->title = $title;
        $this->transferredby = $transferredby;
        $this->createdby = $createdby;
        $this->transferredto = $transferredto;
        $this->reason = $reason;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.notifications.inquirytransferred')
            ->with(['title' => $this->title, 'transferredby' => $this->transferredby, 'createdby' => $this->createdby, 'transferredto' => $this->transferredto, 'reason' => $this->reason]);
    }
}
