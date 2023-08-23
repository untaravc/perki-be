<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MailLog;
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
        foreach ($pending_email as $mail){
            try {
                $email_service->qr_code_access($mail->model_id);
                $mail->update([
                    'status' => 1,
                    'sent_at' => now(),
                ]);
            } catch (\Exception $e) {
                $mail->update([
                   'status' => 2,
                   'log' => $e->getMessage(),
                ]);
            }
        }
    }

    public function create_qr_mail_log(){
//        $transaction_success =
    }
}
