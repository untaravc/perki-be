<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Jobs\CreatePayment;
use App\Mail\SendDefaultMail;
use App\Models\Category;
use App\Models\Contact;
use App\Models\MailLog;
use App\Models\Reference;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CronController extends Controller
{
    public function send_qr_email()
    {
        $pending_email = MailLog::whereStatus(0)
            ->whereLabel('jcu25_qr_access')
            ->limit(1)
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

    public function create_announcement_mail_log()
    {
        $contacts = Contact::whereProvince('DI Yogyakarta')
            ->get();

        $created = [];
        $label = 'carvep_announcement';
        $model = 'contact';
        foreach ($contacts as $contact) {
            $mail_log = MailLog::whereLabel($label)
                ->whereModelId($contact->id)
                ->first();

            if (!$mail_log) {
                $created[] = MailLog::create([
                    "email_receiver" => $contact->email,
                    "receiver_name"  => $contact->name,
                    "label"          => $label,
                    "model"          => $model,
                    "model_id"       => $contact->id,
                    "status"         => 0,
                ]);
            }
        }

        return "Created : " . count($created);
    }

    public function send_announcement_email()
    {
        $email_service = new EmailServiceController();
        return $email_service->send_announcement_email();
    }

    public function sendRegisterProcess()
    {
        $cron = new CronController();
        return $cron->send_qr_email();

        return 'success';
    }

    public function send_abstract_email()
    {
        $oral = MailLog::where('label', 'jcu25_oral_presentation')
            ->whereStatus(0)
            ->limit(1)
            ->get();

        foreach ($oral as $or) {
            $data['user_name'] = $or->receiver_name;
            $data['title'] = $or->title;
            $data['category'] = $or->category;
            $data['email_subject'] = 'Oral Presentation Notification – Jogja Cardiology Update (JCU) 2025';
            $data['view'] = 'email.jcu25.oral_presentation';
            Mail::to($or['email_receiver'])->send(new SendDefaultMail($data));

            $or->update([
                'status' => 1
            ]);
        }

        $display = MailLog::where('label', 'jcu25_display_poster')
            ->whereStatus(0)
            ->limit(1)
            ->get();

        foreach ($display as $or) {
            $data['user_name'] = $or->receiver_name;
            $data['title'] = $or->title;
            $data['category'] = $or->category;
            $data['email_subject'] = 'Poster Presentation Notification – Jogja Cardiology Update (JCU) 2025';
            $data['view'] = 'email.jcu25.displayed_poster';
            Mail::to($or['email_receiver'])->send(new SendDefaultMail($data));

            $or->update([
                'status' => 1
            ]);
        }
    }
}
