<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\MailLog;
use Illuminate\Support\Facades\Config;

class MailController extends Controller
{
    public $gmail_config = [
        'port'       => 465,
        'driver'     => 'smtp',
        'host'       => 'smtp.gmail.com',
        'username'   => 'perki.yogyakarta@gmail.com',
        'sender_name' => 'Perki Yogyakarta',
        'password'   => '',
        'encryption' => 'ssl'
    ]; // testet 07/09/24

    // public $jcu_config = [
    //     'port'       => 587,
    //     'driver'     => 'smtp',
    //     'host'       => 'smtp.gmail.com',
    //     'username'   => 'sekretariat.jcu@gmail.com',
    //     'sender_name' => 'Sekretariat JCU',
    //     'password'   => 'Kardiologi123',
    //     'encryption' => 'tls'
    // ];

    public $vyvy_config = [
        'port'       => 587,
        'driver'     => 'smtp',
        'host'       => 'smtp.gmail.com',
        'username'   => 'vyvy1777@gmail.com',
        'sender_name'   => 'Sekretariat JCU',
        'password'   => '',
        'encryption' => 'tls'
    ]; // Tested 07/09/24

    public $yahoo_config = [
        'port'       => 587,
        'driver'     => 'smtp',
        'host'       => 'smtp.mail.yahoo.com',
        'username'   => 'perki_yogyakarta@yahoo.com',
        'sender_name' => 'Perki Yogyakarta',
        'password'   => '',
        'encryption' => 'tls'
    ]; // Tested 07/09/24

    // public $ilmiah_config = [
    //     'port'       => 587,
    //     'driver'     => 'smtp',
    //     'host'       => 'smtp.gmail.com',
    //     'username'   => 'abstractsubmission.jcu@gmail.com',
    //     'sender_name'   => 'Sekretariat JCU',
    //     'password'   => 'nibdqwghheltgnyg',
    //     'encryption' => 'tls'
    // ];

    public $used_config = null;

    public function setMail()
    {
        $date = date('Y-m-d H:i:s', strtotime('-1 day'));

         $perki_gmail = MailLog::where('email_sender', "perki.yogyakarta@gmail.com")
             ->where('sent_at', '>', $date)->count();

//        $perki_yahoo = MailLog::where('email_sender', "perki_yogyakarta@yahoo.com")
//            ->where('sent_at', '>', $date)->count();
//
//        $vyvy = MailLog::where('email_sender', "vyvy1777@gmail.com")
//            ->where('sent_at', '>', $date)->count();

        // $jcu_gmail = MailLog::where('email_sender', "sekretariat.jcu@gmail.com")
        //     ->where('sent_at', '>', $date)->count();

        // $ilmiah_gmail = MailLog::where('email_sender', "abstractsubmission.jcu@gmail.com")
        //     ->where('sent_at', '>', $date)->count();


        switch (true) {
             case $perki_gmail < 380:
                 $this->gmail_config['password'] = env("MAIL_PASSWORD_PERKI");
                 Config::set('mail', $this->gmail_config);
                 $this->used_config = $this->gmail_config;
                 break;
//            case $perki_yahoo < 420:
//                $this->used_config = $this->yahoo_config;
//                $this->used_config['password'] = env('MAIL_PASSWORD_YAHOO', '');
//                Config::set('mail', $this->used_config);
//                break;
//            case $vyvy < 420:
//                $this->used_config = $this->vyvy_config;
//                $this->used_config['password'] = env('MAIL_PASSWORD_VYVY', '');
//                Config::set('mail', $this->used_config);
//                break;
                // case $jcu_gmail < 420:
                //     Config::set('mail', $this->jcu_config);
                //     $this->used_config = $this->jcu_config;
                //     break;
                // case $ilmiah_gmail < 420:
                //     Config::set('mail', $this->ilmiah_config);
                //     $this->used_config = $this->ilmiah_config;
                //     break;
            default:
                $this->used_config = null;
        }
    }
}
