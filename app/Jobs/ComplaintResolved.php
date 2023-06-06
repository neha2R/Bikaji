<?php

namespace App\Jobs;

use App\Mail\ComplaintResolvedMail;
use App\Traits\SmsTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Services\WhatsappMessageService;

class ComplaintResolved implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, SmsTrait;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $toemails, $tosms, $title, $createdby, $details, $resolvedby, $resolution, $customer_mobile_number, $customer_name;
    
    public function __construct($toemails, $tosms, $title, $createdby, $details, $resolvedby, $resolution, $customer_mobile_number=null, $customer_name=null)
    {
        $this->toemails = $toemails;
        $this->tosms = $tosms;
        $this->title = $title;
        $this->createdby = $createdby;
        $this->details = $details;
        $this->resolvedby = $resolvedby;
        $this->resolution = $resolution;
        $this->customer_mobile_number = $customer_mobile_number;
        $this->customer_name = $customer_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to('support@neologicx.com')
            ->cc($this->toemails)
            ->send(new ComplaintResolvedMail($this->title, $this->createdby, $this->details, $this->resolvedby, $this->resolution));
        // $message = 'Dear'.$this->createdby.' Your complaint has been resolved, Thanks Bikaji';
        // $this->sendsms($this->tosms, $message);

$message ='Dear '.$this->createdby.'

Your complaint No. '.$this->details.' has been resolved successfully. 
You can track your complaint using your mobile number at http://care.bikaji.com/trackcomplaint';

$header='Complaint Resolved (Bikaji Foods)';
$footer = 'Bikaji Foods International Limited';

 $this->whatsappMessage($message,$this->tosms,$header,$footer);
    }
}
