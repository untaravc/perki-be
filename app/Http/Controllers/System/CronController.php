<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MailLog;
use App\Models\Transaction;
use Illuminate\Http\Request;

class CronController extends Controller
{
    public function send_qr_email()
    {
        $pending_email = MailLog::whereStatus(0)
            ->whereLabel('jcu_23_qr_access')
            ->limit(2)
            ->get();

        $email_service = new EmailServiceController();
        foreach ($pending_email as $mail) {
            try {
                $email_service->qr_code_access($mail->model_id);
                $mail->update([
                    'status'  => 1,
                    'sent_at' => now(),
                ]);
            } catch (\Exception $e) {
                $mail->update([
                    'status' => 2,
                    'log'    => $e->getMessage(),
                ]);
            }
        }
    }

    public function send_certificate_email()
    {
        $email_service = new EmailServiceController();
        $email_service->send_event_certificate();
    }

    public function send_abstract_certificate()
    {
        $email_service = new EmailServiceController();
        $email_service->send_abstract_certificate();
    }

    public function send_event_certificate()
    {
        $email_service = new EmailServiceController();
        $email_service->send_event_certificate();
    }

    public function create_qr_mail_log()
    {
        $transaction_success = Transaction::whereStatus(200)
            ->get();

        $created = [];
        foreach ($transaction_success as $transaction) {
            $mail_log = MailLog::whereLabel('jcu_23_qr_access')
                ->whereModelId($transaction->id)
                ->first();

            if (!$mail_log) {
                $created[] = MailLog::create([
                    "email_receiver" => $transaction->user_email,
                    "receiver_name"  => $transaction->user_name,
                    "label"          => "jcu_23_qr_access",
                    "model"          => "transaction",
                    "model_id"       => $transaction->id,
                    "status"         => 0,
                ]);
            }
        }

        return $created;
    }

    public function send_announcment_email()
    {
        return view('email.announcment');
    }
}
