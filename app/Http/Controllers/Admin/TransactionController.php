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
        $data_content = Transaction::orderByDesc('id')->with(['transaction_details' => function ($q) {
            $q->with('event');
        }]);
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

        DB::transaction(function () use ($transaction) {
            $transaction->update([
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

        $transaction->update([
            'status' => 400,
        ]);

        return $this->responseUpdate($transaction);
    }
}
