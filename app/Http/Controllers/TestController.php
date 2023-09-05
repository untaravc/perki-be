<?php

namespace App\Http\Controllers;

use App\Http\Controllers\System\EmailServiceController;
use App\Models\EventUser;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function reset_presensi_1()
    {
        EventUser::whereIn('event_id', [20, 21, 22, 23])
            ->delete();
    }

    public function test_view()
    {
        $ctrl = new EmailServiceController();
        return $ctrl->qr_code_access(124);
    }

    public function sample_qrcode(Request $request)
    {
    }

    public function print_by_name(Request $request)
    {
        return view('print.event_user.nametag_by_name', [
            'name'  => $request->name,
            'title' => $request->title ?? "PARTICIPANT",
            'align' => $request->align ?? "left"
        ]);
    }

    public function check_transaction_status()
    {
        $transactions = Transaction::with('transaction_details')
//            ->whereStatus(400)
            ->get();

        $bug = [];

        foreach ($transactions as $transaction) {
            foreach ($transaction->transaction_details as $detail) {
                if ($detail->status != $transaction->status) {
                    $bug[] = $transaction;
//                    $detail->update([
//                        'status' => $transaction->status
//                    ]);
                }
            }
        }

        return [
            'bug' => $bug,
        ];
    }
}
