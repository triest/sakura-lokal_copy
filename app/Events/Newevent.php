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
        public $eventrequwest = null;
        public $partifocator = null;

        /**
         * Create a new event instance.
         *
         * @return void
         */
        public function __construct($organizer = null, $particicator = null)
        {
            //
            if ($organizer != null) {
                $this->eventrequwest = $organizer;
            }
            if ($particicator != null) {
                $this->partifocator = $particicator;
            }
        }

        /**
         * Get the channels the event should broadcast on.
         *
         * @return \Illuminate\Broadcasting\Channel|array
         */
        public function broadcastOn()
        {  //отправить на канал пользователю


            //  dump($this->partifocator);
            if ($this->eventrequwest != null && isset($this->eventrequwest->id)) {
                return new PrivateChannel('App.User.' . $this->eventrequwest->id);
            } elseif ($this->partifocator != null) {
                return new PrivateChannel('App.User.' . $this->partifocator->id);
            }
        }

        /**
         * Get the channels the event should broadcast on.
         *
         * @return \Illuminate\Broadcasting\Channel|array
         */
        public function broadcastWith()
        {
            if ($this->eventrequwest != null) {
                $this->eventrequwest->load('who');
            } elseif ($this->partifocator != null) {
                $this->partifocator->load('target');
            }
            return ["eventreq" => $this->eventrequwest];
        }
    }
