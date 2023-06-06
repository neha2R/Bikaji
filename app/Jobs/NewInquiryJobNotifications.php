<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewComplaint;
use App\Mail\NewInquiry;
use App\Traits\SmsTrait;

class NewInquiryJobNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,SmsTrait;

    public $uuid,$customername,$details,$mobile,$title,$emails,$customer_mobile;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($uuid,$customername,$details,$mobile,$title,$emails,$customer_mobile)
    {
        $this->uuid=$uuid;
        $this->customername=$customername;
        $this->details=$details;
        $this->mobile=$mobile;
        $this->title=$title;
        $this->emails=$emails;
        $this->customer_mobile=$customer_mobile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to('bikaji@weblogicx.in')->cc($this->emails)->send(new NewInquiry($this->uuid,$this->customername,$this->details,$this->mobile,$this->title)); 
//    'A new enquiry no. '.$this->uuid.' has been registered in the system. Please check the complaint & enquiry portal for faster resolution. Bikaji Foods International Limited'
    $msg ='Dear '.$this->customername.', We have received an enquiry from you. Your enquiry is being shared with the concerned person. One of our team member will contact you soon. Thanks. Bikaji Foods International Limited';
    $this->sendsms($this->customer_mobile,$msg);  
    $this->sendsms($this->mobile,'A new enquiry no. '.$this->uuid.' has been registered in the system. Please check the complaint & enquiry portal for faster resolution. Bikaji Foods International Limited');

$message ='Dear '.$this->customername.',

We have received an enquiry from you. Your enquiry is being shared with the concerned team/person.
One of the team member will contact you soon. 

Thanks.';

$header='Enquiry Registered Successfully';
$footer = 'Bikaji Foods International Limited';

       // $this->sendWhatsappMessage($this->mobiles,$message,$header,$footer);

$this->whatsappMessage($message,$this->customer_mobile,$header,$footer);
    }
    
}
