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

class Newevent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $eventrequwest;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($organizer)
    {
        //
        $this->eventrequwest = $organizer;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {  //отправить на канал пользователю
        return new PrivateChannel('App.User.' . $this->eventrequwest->id);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastWith()
    {
        $this->eventrequwest->load('fromContact');
        return ["eventreq" => $this->eventrequwest];
    }
}
