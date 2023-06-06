<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerComplaintMail extends Mailable
{
    use Queueable, SerializesModels;
    public $name, $title,$uuid;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $title,$uuid)
    {
        $this->name = $name;
        $this->title = $title;
        $this->uuid = $uuid;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name = $this->name;
        $title = $this->title;
        $uuid = $this->uuid;
        return $this->view('customercomplaint.mail', compact('name', 'title','uuid'));
    }
}
