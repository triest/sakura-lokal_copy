<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Eventrequwest;

class Newevent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $eventrequwest;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Eventrequwest $eventrequwest)
    {
        //
        $this->eventrequwest = $eventrequwest;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('eventsrequwest.' . $this->eventrequwest->to);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastWith()
    {
        $this->message->load('fromContact');
        return ["message" => $this->message];
    }
}
