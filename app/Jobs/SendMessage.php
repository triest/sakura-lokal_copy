<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mail, $anket, $type, $message, $ankets, $events;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        $mail,
        $anket,
        $message,
        $type = 'newMessage',
        $ankets = null,
        $events = null
    ) {
        //
        $this->mail = $mail;
        $this->anket = $anket;
        $this->type = $type;
        $this->message = $message;
        $this->ankets = $ankets;
        $this->events = $events;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $mail = $this->mail;
        $anket = $this->anket;
        if ($this->anket != null) {
            $city = $this->anket->city()->first();
        } else {
            $city = null;
        }
        $ankets = $this->ankets;


        switch ($this->type) {
            case 'newMessage':
                try {
                    Mail::send('email.newMessage',
                        [
                            'text'  => $this->message,
                            'anket' => $this->anket,
                        ],
                        function ($message) use ($mail, $anket, $city) {
                            $message
                                ->to($mail, $anket->name)
                                ->from('sakura-testmail@sakura-city.info')
                                ->subject('У вас новое сообщение');

                        });
                } catch
                (\Exception $exception) {
                }
                break;
            case 'newAnkets':
                Mail::send('email.newAnkets',
                    [
                        'text'   => $this->message,
                        'anket'  => $this->anket,
                        'ankets' => $this->ankets,
                    ],
                    function ($message) use ($mail, $anket, $city, $ankets) {
                        $message
                            ->to($mail, $anket->name)
                            ->from('sakura-testmail@sakura-city.info')
                            ->subject('У вас новое сообщение');

                    });
                break;
            case 'anketViews':
                if ($this->ankets == null) {
                    return;
                }

                Mail::send('email.anketViews',
                    [
                        'text'   => $this->message,
                        'ankets' => $this->ankets,
                    ],
                    function ($message) use ($mail, $anket, $city, $ankets) {
                        $message
                            ->to($mail, $anket->name)
                            ->from('sakura-testmail@sakura-city.info')
                            ->subject('У вас новое сообщение');

                    });

            case 'event-today':
                ;
                if ($this->events == null) {
                    return;
                }
                $events = $this->events;
                $anket = $this->anket;


                Mail::send('email.eventsToday',
                    [
                        'events' => $events,
                    ],
                    function ($message) use ($mail, $anket) {
                        $message
                            ->to($mail, $anket->name)
                            ->from('sakura-testmail@sakura-city.info')
                            ->subject('У вас новое сообщение');

                    });

                break;
            case 'event_accept':
                $event = $this->events;

                Mail::send('email.eventsAccept',
                    [
                        'event' => $event,
                    ],
                    function ($message) use ($mail, $event) {
                        $message
                            ->to($mail, $event->name)
                            ->from('sakura-testmail@sakura-city.info')
                            ->subject('Ваша заявка  на участие в событии принята');
                    });

                break;
        }

    }
}
