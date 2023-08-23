<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\System\EmailServiceController;
use App\Mail\SendDefaultMail;
use App\Models\MailLog;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $data_content = Transaction::orderByDesc('id')->with([
            'transaction_details' => function ($q) {
                $q->with('event');
            },
            'users',
            'user'
        ])->whereParentId(0);
        $data_content = $this->withFilter($data_content, $request);
        $data_content = $data_content->paginate($request->per_page ?? 25);

        $collect = collect($this->response);
        return $collect->merge($data_content);
    }

    public function withFilter($data_content, $request)
    {
        if ($request->s) {
            $data_content = $data_content->where('user_name', 'LIKE', '%' . $request->s . '%');
        }

        if ($request->id) {
            $data_content = $data_content->where('id', $request->id);
        }

        if ($request->job_type_code) {
            $data_content = $data_content->where('job_type_code', $request->job_type_code);
        }

        if ($request->status) {
            $data_content = $data_content->where('status', $request->status);
        } else {
            $data_content = $data_content->where('status', '!=', 400);
        }
        return $data_content;
    }

    public function confirm(Request $request)
    {
        $transaction = Transaction::where('status', '>', 100)
            ->find($request->transaction_id);

        if (!$transaction) {
            return $this->responseErrors('transaksi tidak dapat di proses.');
        }

        DB::transaction(function () use ($transaction, $request) {
            if ($request->total) {
                $total = $request->total;
            } else {
                $total = $transaction->total;
            }
            $transaction->update([
                'total'   => $total,
                'status'  => 200,
                'paid_at' => now()
            ]);

            TransactionDetail::whereTransactionId($transaction->id)
                ->update([
                    'status' => 200
                ]);
        });

        // kirim invoice
        $email = new EmailServiceController();
        $email->invoice($transaction->id);

        // create email log
        $mail_log = [
            "email_receiver" => $transaction->user_email,
            "receiver_name"  => $transaction->user_name,
            "label"          => "jcu_23_qr_access",
            "model"          => "transaction",
            "model_id"       => $transaction->id,
            "status"         => 0,
        ];

        MailLog::create($mail_log);

        return $this->responseUpdate($transaction);
    }

    public function delete_transaction(Request $request)
    {
        $transaction = Transaction::where('status', '!=', 200)
            ->find($request->transaction_id);

        if (!$transaction) {
            return $this->responseErrors('transaksi tidak dapat di hapus.');
        }

        DB::transaction(function () use ($transaction) {
            $transaction->update([
                'status' => 400,
            ]);

            TransactionDetail::whereTransactionId($transaction->id)
                ->update([
                    'status' => 400
                ]);
        });

        return $this->responseUpdate($transaction);
    }

    public function transaction_recap()
    {
        $transactions = Transaction::where('status', '!=', 400)
            ->where('status', '>', 100)
            ->orderByDesc('status')
            ->with(['transaction_details' => function ($q) {
                $q->orderBy('event_id');
            }])->get();

        return view('print.transaction.list', compact('transactions'));
    }

    public function invoice_pdf($transaction_id, Request $request)
    {
        $data['transaction'] = Transaction::with(['transaction_details' => function ($q) {
            $q->with('event');
        }, 'user'])
            ->find($transaction_id);

        $data['note'] = $request->note ?? '';

        return view('email.jcu22.invoice_pdf', $data);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('', $data)
            ->setPaper([0, 0, 420, 595]);
        $content = $pdf->download()->getOriginalContent();

        $data['pdf_path'] = 'invoice_pdf/' . $data['transaction']['number'] . '.pdf';
        Storage::disk('local')->put('invoice_pdf/' . $data['transaction']['number'] . '.pdf', $content);

        $data['attach'] = Storage::path($data['pdf_path']);

        try {
            if (env('APP_ENV') == "prod") {
                Mail::to($data['user']['email'])->send(new SendDefaultMail($data));
            } else {
                Mail::to('vyvy1777@gmail.com')->send(new SendDefaultMail($data));
            }

//            MailLog::create($mail_log);
            return 'sent';
        } catch (\Exception $exception) {
            $mail_log['sent_at'] = null;
            $mail_log['status'] = 2;

            MailLog::create($mail_log);
            return 'failed';
        }
    }
}
