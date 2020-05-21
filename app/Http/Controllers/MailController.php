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
    }
