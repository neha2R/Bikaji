<?php

namespace App\Jobs;

use App\Mail\CustomerComplaintMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Traits\SmsTrait;

class CustomerComplaintFormNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,SmsTrait;
    public $email, $name, $title;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($uuid,$customername,$details,$mobile,$title,$emails)
    {
        $this->uuid=$uuid;
        $this->name=$customername;
        $this->details=$details;
        $this->mobile=$mobile;
        $this->title=$title;
        $this->email=$emails;
       
        // dd($emails);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to('support@neologicx.com')->cc($this->email)->send(new CustomerComplaintMail($this->name,$this->title,$this->uuid)); 
        $this->sendsms($this->mobile,'Dear '.$this->name.' Your complaint '.$this->uuid.' has been registered successfully. You can track your complaint using your mobile number at http://care.bikaji.com/trackcomplaint Bikaji Foods International Limited');

      $message ='Dear '.$this->name.'

Your complaint No. '.$this->uuid.' with title '.$this->title.' is registered successfully at Bikaji Care Portal.
You can track your complaint using your mobile number at http://care.bikaji.com/trackcomplaint';

$header='Complaint Registered: Bikaji Foods';
$footer = 'Bikaji Foods International Limited';

        
        $this->whatsappMessage($message,$this->mobile,$header,$footer);
    }
}
