<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Mail\SendDefaultMail;
use App\Models\MailLog;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class EmailServiceController extends Controller
{
    public function register()
    {
        $data = [
            'name' => '',
            'link' => '',
        ];
        return view('email.jcu22.email-confirmation', $data);
    }

    public function bill($transaction_id = null)
    {
        $transaction_id = $transaction_id ?? 123;

        $data['transaction'] = Transaction::find($transaction_id);
        $data['transaction_details'] = TransactionDetail::with('event')
            ->orderBy('event_id')
            ->whereTransactionId($transaction_id)
            ->get();

        $data['user'] = User::find($data['transaction']['user_id']);

        $data['view'] = 'email.jcu22.bill';
        $data['email_subject'] = 'JCU 2023: Bill ' . $data['transaction']['number'];

//        return view($data['view'], $data);

        $mail_log = [
            "email_sender"   => "perki.yogyakarta@gmail.com",
            "email_receiver" => $data['user']['email'],
            "receiver_name"  => $data['user']['name'],
            "label"          => "bill",
            "category"       => null,
            "title"          => $data['email_subject'],
            "model"          => "transaction",
            "model_id"       => $transaction_id,
            "status"         => 1,
            "sent_at"        => now(),
        ];

        try {
            if (env('APP_ENV') == "prod") {
                Mail::to($data['user']['email'])->send(new SendDefaultMail($data));
            } else {
                Mail::to('vyvy1777@gmail.com')->send(new SendDefaultMail($data));
            }

            MailLog::create($mail_log);
        } catch (\Exception $exception) {
            $mail_log['sent_at'] = null;
            $mail_log['status'] = 2;
            $mail_log['note'] = $exception->getMessage();

            MailLog::create($mail_log);
        }
    }

    public function invoice($transaction_id = null)
    {
        $transaction_id = $transaction_id ?? 18;

        $data['transaction'] = Transaction::find($transaction_id);
        $data['transaction_details'] = TransactionDetail::with('event')
            ->orderBy('event_id')
            ->whereTransactionId($transaction_id)
            ->get();

        $data['user'] = User::find($data['transaction']['user_id']);

        $data['view'] = 'email.jcu22.invoice';
        $data['email_subject'] = 'JCU 2023: Invoice ' . $data['transaction']['number'];

//        return view($data['view'], $data);

        $mail_log = [
            "email_sender"   => "perki.yogyakarta@gmail.com",
            "email_receiver" => $data['user']['email'],
            "receiver_name"  => $data['user']['name'],
            "label"          => "invoice",
            "category"       => null,
            "title"          => $data['email_subject'],
            "model"          => "transaction",
            "model_id"       => $transaction_id,
            "status"         => 1,
            "sent_at"        => now(),
        ];

        try {
            if (env('APP_ENV') == "prod") {
                Mail::to($data['user']['email'])->send(new SendDefaultMail($data));
            } else {
                Mail::to('vyvy1777@gmail.com')->send(new SendDefaultMail($data));
            }

            MailLog::create($mail_log);
        } catch (\Exception $exception) {
            $mail_log['sent_at'] = null;
            $mail_log['status'] = 2;

            MailLog::create($mail_log);
        }
    }

    public function send_new_password(User $user){
        $data['user'] = $user;

        $data['view'] = 'email.set_new_password';
        $data['email_subject'] = 'JCU 2023: Set New Password';

        $mail_log = [
            "email_sender"   => "perki.yogyakarta@gmail.com",
            "email_receiver" => $data['user']['email'],
            "receiver_name"  => $data['user']['name'],
            "label"          => "send_new_password",
            "category"       => null,
            "title"          => $data['email_subject'],
            "model"          => "user",
            "model_id"       => $user->id,
            "status"         => 1,
            "sent_at"        => now(),
        ];

        try {
            if (env('APP_ENV') == "prod") {
                Mail::to($data['user']['email'])->send(new SendDefaultMail($data));
            } else {
                Mail::to('vyvy1777@gmail.com')->send(new SendDefaultMail($data));
            }

            MailLog::create($mail_log);
        } catch (\Exception $exception) {
            $mail_log['sent_at'] = null;
            $mail_log['status'] = 2;

            MailLog::create($mail_log);
        }
    }
}
