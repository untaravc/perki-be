<?php

namespace App\Http\Controllers;

use App\Http\Controllers\System\EmailServiceController;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test_view(){
        $ctrl = new EmailServiceController();
        return $ctrl->qr_code_access(124);
    }

    public function sample_qrcode(Request $request){}

    public function check_transaction_status(){
        $transactions = Transaction::with('transaction_details')
//            ->whereStatus(400)
            ->get();

        $bug = [];

        foreach ($transactions as $transaction){
            foreach ($transaction->transaction_details as $detail){
                if($detail->status != $transaction->status){
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
