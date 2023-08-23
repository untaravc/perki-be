<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\System\EmailServiceController;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
//            ->where('status', '<', 200)
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

    public function transaction_recap(){
        $transactions = Transaction::where('status', '!=', 400)
            ->where('status','>',100)
            ->orderByDesc('status')
            ->with(['transaction_details'=>function($q){
                $q->orderBy('event_id');
            }])->get();

        return view('print.transaction.list', compact('transactions'));
    }
}
