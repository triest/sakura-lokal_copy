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

    protected $mail, $anket, $type, $message, $ankets;

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
        $ankets = null
    ) {
        //
        $this->mail = $mail;
        $this->anket = $anket;
        $this->type = $type;
        $this->message = $message;
        $this->ankets = $ankets;
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
        $city = $this->anket->city()->first();
        $ankets = $this->ankets;
        dump($ankets);

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

        }

    }
}
