<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Mail\SendDefaultMail;
use App\Models\MailLog;
use App\Models\Post;
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
                // Mail::to('vyvy1777@gmail.com')->send(new SendDefaultMail($data));
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
        $data['email_subject'] = 'JCU 2024: Invoice ' . $data['transaction']['number'];

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
        $data['email_subject'] = 'JCU 2024: QR Code Access ' . $data['transaction']['number'];
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
            // Mail::to($data['transaction']['user_email'])->send(new SendDefaultMail($data));
        } else {
            Mail::to('vyvy1777@gmail.com')->send(new SendDefaultMail($data));
        }

        $fonnte = new FonnteServiceController();
        $fonnte->generateQrMsg($data['transaction']);

        return true;
    }

    public function send_event_certificate()
    {
        // setup
        $models = ['jcu23_certificate'];
        $file = public_path('assets/certificates/jcu23_sympo2.png');
        $data['email_subject'] = "Perki Jogja";
        // --- end setup

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
            //            $user = User::find($mail['model_id']);
            //            if (!$user) {
            //                continue;
            //            }

            $mail_data['img'] = base64_encode(file_get_contents($file));
            $mail_data['name'] = $mail['receiver_name'];
            $mail_data['name_top'] = 400;
            $mail_data['name_left'] = 260;

            $pdf = Pdf::setOptions([
                'dpi'             => 200,
                'defaultFont'     => 'sans-serif',
                'isRemoteEnabled' => true,
            ])->loadView('print.events.certificate', $mail_data)
                ->setPaper('a4', 'landscape');

            $file_name = 'Certificate ' . preg_replace('/\s+/', ' ', trim($mail_data['name'])) . '_' . time() . '.pdf';
            $content = $pdf->download()->getOriginalContent();
            $file_path = 'certificates/' . $mail->label . "/" . $file_name;
            Storage::disk('local')->put($file_path, $content);
            //            return view('print.events.certificate', $mail_data);
            $data['email_receiver'] = $mail->email_receiver;
            $data['receiver_name'] = $mail->receiver_name;
            $data['title'] = $mail->title;
            $data['view'] = 'email.certificate';
            $data['attach'] = public_path('storage/' . $file_path);
            //            $data['attach2'] = public_path('assets/docs/template-full-paper-proceeding-jcu-2023.docx');
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

    public function send_announcement_email()
    {
        $mail_ctrl = new MailController();
        $mail_ctrl->setMail();

        if ($mail_ctrl->used_config == null) {
            return 'Out of quota.';
        }

        $labels = ['jcu24_announcement'];
        $data['email_subject'] = "Jogja Cardiology Update 2024 - 7th JINCARTOS";
        $data['sender_email'] = $mail_ctrl->used_config['username'];

        $mail_logs = MailLog::whereIn('label', $labels)
            ->whereStatus(0)
            ->limit(2)
            ->get();

        foreach ($mail_logs as $mail) {
            $data['email_receiver'] = $mail->email_receiver;
            $data['receiver_name'] = $mail->receiver_name;
            $data['view'] = 'email.announcment';

            try {
                Mail::to(preg_replace('/\s+/', ' ', trim($mail['email_receiver'])))
                    ->send(new SendDefaultMail($data));

                MailLog::find($mail->id)
                    ->update([
                        'email_sender' => $data['sender_email'],
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

    public function accepted_post(Post $post)
    {
        $data['view'] = 'email.poster_accepted';
        $data['email_subject'] = 'Jogja Cardiology Update 2024: Accepted Abstract';
        $data['post'] = $post;

        // return view($data['view'], $data);

        $mail_log = [
            "email_sender"   => "perki.yogyakarta@gmail.com",
            "email_receiver" => $post['user']['email'],
            "receiver_name"  => $post['user']['name'],
            "label"          => "acc_post",
            "category"       => null,
            "title"          => $data['email_subject'],
            "model"          => "acc_post",
            "model_id"       => $post->id,
            "status"         => 1,
            "sent_at"        => now(),
        ];

        try {
            if (env('APP_ENV') == "prod") {
                Mail::to($post['user']['email'])->send(new SendDefaultMail($data));
            } else {
                Mail::to('vyvy1777@gmail.com')->send(new SendDefaultMail($data));
            }

            MailLog::create($mail_log);
        } catch (\Exception $exception) {
            $mail_log['sent_at'] = null;
            $mail_log['status'] = 2;
            $mail_log['log'] = $exception->getMessage();

            MailLog::create($mail_log);
        }
    }
}
