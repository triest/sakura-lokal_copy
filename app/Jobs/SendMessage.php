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

        protected $mail, $anket, $type, $message;

        /**
         * Create a new job instance.
         *
         * @return void
         */
        public function __construct($mail, $anket, $message, $type = 'newMessage')
        {
            //
            $this->mail = $mail;
            $this->anket = $anket;
            $this->type = $type;
            $this->message = $message;
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
            switch ($this->type) {
                case 'newMessage':
                    try {
                        Mail::send('email.newMessage',
                                [
                                        'text' => $this->message,
                                        'anket' => $this->anket
                                ],
                                function ($message) use ($mail) {
                                    $message
                                            ->to($mail, 'some guy')
                                            //->from('newmail.sm@yandex.ru')
                                            ->from('sakura-testmail@sakura-city.info')
                                            ->subject('У вас новое сообщение');

                                });
                    } catch
                    (\Exception $exception) {
                    }
            }

        }
    }
