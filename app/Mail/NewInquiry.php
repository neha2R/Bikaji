<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewInquiry extends Mailable
{
    use Queueable, SerializesModels;
    public $uuid,$customername,$details,$mobile,$title;
    /**
     * Create a new messaage instance.
     *
     * @return void
     */
    public function __construct($uuid,$customername,$details,$mobile,$title)
    {
        $this->uuid=$uuid;
        $this->customername=$customername;
        $this->details=$details;
        $this->mobile=$mobile;
        $this->title=$title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $uuid=$this->uuid;
        $details=$this->details;
        $mobile=$this->mobile;
        $name=$this->customername;
        $title=$this->title;
        return $this->view('mail.notifications.newinquiry',compact('uuid','details','mobile','name','title'));
    }
}
