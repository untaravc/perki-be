<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\System\EmailServiceController;
use App\Http\Controllers\System\FonnteServiceController;
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

    public function show($id)
    {
        $data = Transaction::orderByDesc('id')->with([
            'transaction_details' => function ($q) {
                $q->with('event');
            },
            'users',
            'user',
        ])->whereParentId(0)
            ->find($id);

        $this->response['result'] = $data;
        return $this->response;
    }

    public function withFilter($data_content, $request)
    {
        if ($request->user_name) {
            $data_content = $data_content->where('user_name', 'LIKE', '%' . $request->user_name . '%');
        }

        if ($request->id) {
            $data_content = $data_content->where('id', $request->id);
        }

        if ($request->section) {
            $data_content = $data_content->where('section', $request->section);
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
            if (isset($request->total)) {
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

        $children = Transaction::whereParentId($transaction->id)->get();

        if (count($children) > 0) {
            foreach ($children as $child) {
                $child->update([
                    'status' => 200,
                    'paid_at' => now()
                ]);

                TransactionDetail::whereTransactionId($child->id)
                    ->update([
                        'status' => 200
                    ]);
            }
        }

        // kirim invoice
        $email = new EmailServiceController();
        $email->invoice($transaction->id);

        // create email log
        $mail_log = [
            "email_receiver" => $transaction->user_email,
            "receiver_name"  => $transaction->user_name,
            "label"          => "carvep_qr_access",
            "model"          => "transaction",
            "model_id"       => $transaction->id,
            "status"         => 0,
        ];

        MailLog::create($mail_log);

        return $this->responseUpdate($transaction);
    }

    public function delete_transaction(Request $request)
    {
        $transaction = Transaction::find($request->transaction_id);

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

    public function transaction_recap(Request $request)
    {
        $transactions = Transaction::where('status', '!=', 400)
            ->where('status', '>', 100)
            ->when($request->section, function ($q) use ($request) {
                $q->whereSection($request->section);
            })->when($request->note, function ($q) use ($request) {
                $q->whereNote($request->note);
            })->when($request->gl_name, function ($q) use ($request) {
                $q->whereGlName($request->gl_name);
            })
            ->orderByDesc('status')
            ->orderBy('id')
            ->with([
                'transaction_details' => function ($q) {
                    $q->orderBy('event_id');
                },
                'user'
            ])
            ->get();

        $query['section'] = $request->section;

        return view('print.transaction.list', compact('transactions', 'query'));
    }

    public function invoice_pdf($transaction_id, Request $request)
    {
        $data['transaction'] = Transaction::with(['transaction_details' => function ($q) {
            $q->with('event');
        }, 'user'])
            ->find($transaction_id);

        $data['note'] = $request->note ?? '';
        if ($request->status_label) {
            $data['status_label'] = $request->status_label;
        } else {
            $data['status_label'] = $data['transaction']['status_label'];
        }

        return view('email.jcu22.invoice_pdf', $data);
    }

    public function notify($id)
    {
        $transaction = Transaction::where('status', '!=', 200)
            ->find($id);

        if ($transaction) {
            $fonnte = new FonnteServiceController();
            $fonnte->generateMessage($transaction);
        }

        return $this->responseUpdate($transaction);
    }

    public function validate_transaction(Request $request, $id)
    {
        $transaction = Transaction::find($id);

        if ($transaction) {
            $transaction->update([
                'note' => $request->note,
                'gl_name' => $request->gl_name,
                'gl_date' => $request->gl_date,
                'gl_status' => $request->gl_status,
            ]);
        }

        $next = Transaction::where('id', '>', $id)
            ->where('status', 200)
            ->where('section', 'carvep')
            ->first();

        if ($next) {
            $this->response['result']['next_id'] = $next->id;
        }

        return $this->response;
    }
}
