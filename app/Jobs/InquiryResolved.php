<?php

namespace App\Jobs;

use App\Mail\InquiryResolved as AppInquiryResolved;
use App\Traits\SmsTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class InquiryResolved implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, SmsTrait;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $toemails, $tosms, $title, $createdby, $details, $resolvedby, $resolution;

    public function __construct($toemails, $tosms, $title, $createdby, $details, $resolvedby, $resolution)
    {
        $this->toemails = $toemails;
        $this->tosms = $tosms;
        $this->title = $title;
        $this->createdby = $createdby;
        $this->details = $details;
        $this->resolvedby = $resolvedby;
        $this->resolution = $resolution;
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
            ->send(new AppInquiryResolved($this->title, $this->createdby, $this->details, $this->resolvedby, $this->resolution));
        // $message = 'An inquiry has been resolved. Please check the portal for "'.$this->details.'" details';
        $message = 'Dear ' . $this->title . ', Your complaint has been resolved. Thanks Bikaji';
        $this->sendsms($this->tosms, $message);
    }
}
