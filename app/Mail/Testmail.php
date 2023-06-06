<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Testmail extends Mailable
{
    use Queueable, SerializesModels;
    public $a,$b,$c,$d;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($a,$b,$c,$d)
    {
        $this->a=$a;
        $this->b=$b;
        $this->c=$c;
        $this->d=$d;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('welcome',['a'=>$this->a,'b'=>$this->b,'c'=>$this->c,'d'=>$this->d]);
    }
}
