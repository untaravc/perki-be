<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class EventController extends BaseController
{
    public function event_schedule(Request $request){
        $user = $request->user();

        $transaction_details = TransactionDetail::whereUserId($user['id'])
            ->whereHas('transaction', function ($q){
                $q->where('status', 200);
            })
            ->with('event')
            ->get();

        $this->response['result'] = $transaction_details;
        return $this->response;
    }
}
