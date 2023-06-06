<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewComplaint;
use App\Traits\SmsTrait;

class NewComplaintNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,SmsTrait;

    public $uuid,$customername,$details,$mobile,$title,$emails,$customer_mobile;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($uuid,$customername,$details,$mobile,$title,$emails)
    {
        $this->uuid=$uuid;
        $this->customername=$customername;
        $this->details=$details;
        $this->mobile=$mobile;
        $this->title=$title;
        $this->emails=$emails;
       
        // dd($emails);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      
        Mail::to('support@neologicx.com')->cc($this->emails)->send(new NewComplaint($this->uuid,$this->customername,$this->details,$this->mobile,$this->title)); 
       $msg ='A new complaint '.$this->uuid.' has been registered in the system. Please check the complaint portal for faster resolution. Bikaji Foods International Limited';
        $this->sendsms($this->mobile,$msg);


$message ='Dear Sir/Ma\'am,

A new complaint No. '.$this->uuid.' has been registered in the system.

Please check the Bikaji Grievance Management Portal for faster resolution by clicking on this link: http://care.bikaji.com/auth/login';

$header='New Complaint Registered: Bikaji Grievance Management Portal';
$footer = 'Bikaji Foods International Limited';

      $this->whatsappMessage($message,$this->mobile,$header,$footer);
        // $this->sendsms($this->mobiles,'Dear "'.$this->customername.'"Your complaint "'.$this->title.'" has been registered succesfully. You can track your complait using your mobile no at http://care.bikaji.com/trackcomplaint Bikaji Foods Internationl Limited');
    }
}
