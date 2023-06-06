<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerRatingMail;
use App\Traits\SmsTrait;
class RatingMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,SmsTrait;
    public $customername,$mobile,$email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($customername,$mobile,$email=null)
    {

        $this->customername=$customername;
        $this->mobile=$mobile;
        $this->email=$email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       
        if(!empty($this->email)){
           
        Mail::to('support@neologicx.com')
        ->cc($this->email)
        ->send(new CustomerRatingMail($this->customername));
        }
        $message = 'Dear '.$this->customername.' Your complaint has been resolved, Thanks Bikaji';
        $this->sendsms($this->mobile, $message);

    }
}
