<?php

    namespace App\Http\Controllers;

    use App\Girl;
    use App\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Mail;

    class MailController extends Controller
    {
        //
        public function testemail()
        {
            $testname = 'testname1';
            $mail = 'dmitry.tikhonenko@yandex.ru';
            $mail = 'triest21@gmail.com';
            //echo $mail;
            try {
                Mail::send('email.test', ['name' => $testname], function ($message) use ($mail) {
                    $message
                            ->to($mail, 'some guy')
                            //->from('newmail.sm@yandex.ru')
                            ->from('98280c33e4-462dfb@inbox.mailtrap.io')
                            ->subject('Welcome');

                });
            } catch (\Exception $exception) {
                echo '<br>';
                echo 'error:';
                echo '<br>';
                echo $exception->getMessage();
            }
        }

        public function newEmailNotification($user_id, $type_notiication)
        {
            $testname = 'testname1';
            $user = User::select('id', 'name', 'email')->where('id', $user_id)->first();
            $anket = Girl::select('id', 'name', 'main_image')->where('user_id', $user_id)->first();
            $mail = $user->email;
            try {
                Mail::send('email.newMessage', ['name' => $testname, 'anket' => $anket],
                        function ($message) use ($mail, $user) {
                            $message
                                    ->to($mail, $user->name)
                                    ->from('sakura-testmail@sakura-city.info')
                                    ->subject('У вас новая заявка');

                        });
            } catch (\Exception $exception) {
                echo '<br>';
                echo 'error:';
                echo '<br>';
                echo $exception->getMessage();
            }
        }

    }
