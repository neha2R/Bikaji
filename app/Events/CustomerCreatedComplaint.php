<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CustomerCreatedComplaint implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    public $title;
    // public $id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($title)
    {
        // $this->id=$id;
        $this->title = $title;
        $this->message  = "A new complaint <b> ".$this->title." </b> has been registered by a customer. Please check the <b>Customer Complaint</b> section.";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['customercomplaint-create'];
    }

    public function broadcastAs()
    {
        return 'customercomplaintcreate';
    }
}
