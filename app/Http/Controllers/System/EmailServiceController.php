<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Mail\SendDefaultMail;
use App\Models\Event;
use App\Models\MailLog;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

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
//                Mail::to('vyvy1777@gmail.com')->send(new SendDefaultMail($data));
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
                if ($data['user']['email'] != $data['transaction']['user_email']) {
                    Mail::to($data['transaction']['user_email'])->send(new SendDefaultMail($data));
                }
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

    public function send_new_password(User $user)
    {
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

    public function qr_code_access($transaction_id)
    {
        $data['transaction'] = Transaction::find($transaction_id);
        $data['transaction_details'] = TransactionDetail::with('event')
            ->orderBy('event_id')
            ->whereTransactionId($transaction_id)
            ->get();

        $data['user'] = User::find($data['transaction']['user_id']);

        $data['view'] = 'email.jcu22.qr_code';
        $data['view_pdf'] = 'print.transaction.qr_code';
        $data['email_subject'] = 'JCU 2023: Code Access ' . $data['transaction']['number'];
        $data['path'] = '/assets/qr_code/' . $data['transaction']['number'] . '.svg';

        QrCode::size(500)
            ->errorCorrection('H')
            ->generate($data['transaction']['number'], public_path($data['path']));

        $get_img = file_get_contents(public_path($data['path']));
        $data['qr_link'] = base64_encode($get_img);

//        return view($data['view'], $data);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView($data['view_pdf'], $data)
            ->setPaper([0, 0, 420, 595]);
        $content = $pdf->download()->getOriginalContent();

        $data['pdf_path'] = 'qr_pdf/' . $data['transaction']['number'] . '.pdf';
        Storage::disk('local')->put('qr_pdf/' . $data['transaction']['number'] . '.pdf', $content);

        $data['attach'] = Storage::path($data['pdf_path']);

        if (env('APP_ENV') == "prod") {
            Mail::to($data['transaction']['user_email'])->send(new SendDefaultMail($data));
        } else {
            Mail::to('vyvy1777@gmail.com')->send(new SendDefaultMail($data));
        }

        return true;
    }

    public function send_abstract_certificate()
    {
        $models = ['abstract_certificate'];
        $email_sent = MailLog::where('sent_at', '>', date('Y-m-d H:i:s', strtotime(now() . '-24 hours')))
            ->count();

        if ($email_sent > 400) {
            return '';
        }

        $mail_logs = MailLog::whereIn('label', $models)
            ->whereStatus(0)
//            ->where('email_receiver', 'vyvy1777@gmail.com') // tester email
            ->limit(1)
            ->get();

        foreach ($mail_logs as $mail) {
            $user = User::find($mail['model_id']);
            if (!$user) {
                continue;
            }

            $file = public_path('assets/certificates/eposter_finalist.png');

            $mail_data['img'] = base64_encode(file_get_contents($file));
            $mail_data['name'] = $mail['receiver_name'];
            $mail_data['name_top'] = 380;
            $mail_data['name_left'] = 260;

            $pdf = Pdf::setOptions([
                'dpi'             => 200,
                'defaultFont'     => 'sans-serif',
                'isRemoteEnabled' => true,
            ])->loadView('print.events.certificate', $mail_data)
                ->setPaper('a4', 'landscape');

            $file_name = 'e-poster ' . preg_replace('/\s+/', ' ', trim($mail_data['name'])) . '_' . time() . '.pdf';
            $content = $pdf->download()->getOriginalContent();
            $file_path = 'certificates/' . $mail->label . "/" . $file_name;
            Storage::disk('local')->put($file_path, $content);
//            return view('print.events.certificate', $mail_data);
            $data['email_receiver'] = $mail->email_receiver;
            $data['receiver_name'] = $mail->receiver_name;
            $data['title'] = $mail->title;
            $data['email_subject'] = "Full Paper Submission Request - Jogja Cardiology Update 2023";
            $data['view'] = 'email.request-submission';
            $data['attach'] = public_path('storage/' . $file_path);
            $data['attach2'] = public_path('assets/docs/template-full-paper-proceeding-jcu-2023.docx');
            $data['content'] = $mail->content;

//            return view($data['view'], $mail);
            try {
                Mail::to(preg_replace('/\s+/', ' ', trim($mail['email_receiver'])))
                    ->send(new SendDefaultMail($data));

                MailLog::find($mail->id)
                    ->update([
                        'email_sender' => env('MAIL_USERNAME'),
                        'status'       => 1,
                        'sent_at'      => now()
                    ]);
            } catch (\Exception $e) {
                MailLog::find($mail->id)
                    ->update([
                        'status' => 2,
                        'log'    => $e->getMessage(),
                    ]);
                return $e->getMessage();
            }
        }
    }

    public function send_event_certificate()
    {
        $models = ['abstract_certificate'];
        $email_sent = MailLog::where('sent_at', '>', date('Y-m-d H:i:s', strtotime(now() . '-24 hours')))
            ->count();

        if ($email_sent > 400) {
            return '';
        }

        $mail_logs = MailLog::whereIn('label', $models)
            ->whereStatus(0)
            ->where('email_receiver', 'vyvy1777@gmail.com') // tester email
            ->limit(1)
            ->get();

        foreach ($mail_logs as $mail) {
            $event = Event::whereSlug($mail->category)->first();
            if (!$event) {
                continue;
            }

            $file = public_path('assets/certificates/' . $event->certificate);

            $mail_data['img'] = base64_encode(file_get_contents($file));
            $mail_data['name'] = $mail['receiver_name'];
            $mail_data['name_top'] = $event->certificate_space_top;
            $mail_data['name_left'] = $event->certificate_space_left;

//            return view('print.events.certificate', $mail_data);
            $pdf = Pdf::setOptions([
                'dpi'             => 200,
                'defaultFont'     => 'sans-serif',
                'isRemoteEnabled' => true,
            ])->loadView('print.events.certificate', $mail_data)
                ->setPaper('a4', 'landscape');

            $file_name = $event->name . ' ' . preg_replace('/\s+/', ' ', trim($mail_data['name'])) . '_' . time() . '.pdf';
            $content = $pdf->download()->getOriginalContent();
            $file_path = 'certificates/' . $mail->label . "/" . $file_name;
            Storage::disk('local')->put($file_path, $content);

            $data['email_receiver'] = $mail->email_receiver;
            $data['receiver_name'] = $mail->receiver_name;
            $data['title'] = $mail->title;
            $data['email_subject'] = "Certificate " . $event['name'];
            $data['view'] = 'email.certificate';
            $data['attach'] = public_path('storage/' . $file_path);
            $data['content'] = $mail->content;

            // return view('email.certificate', $mail);
            try {
                Mail::to(preg_replace('/\s+/', ' ', trim($mail['email_receiver'])))
                    ->send(new SendDefaultMail($data));

                MailLog::find($mail->id)
                    ->update([
                        'email_sender' => env('MAIL_USERNAME'),
                        'status'       => 1,
                        'sent_at'      => now()
                    ]);
            } catch (\Exception $e) {
                MailLog::find($mail->id)
                    ->update([
                        'status' => 2,
                        'log'    => $e->getMessage(),
                    ]);
                return $e->getMessage();
            }
        }

        return $mail_logs;
    }
}
