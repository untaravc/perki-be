<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register_event(Request $request)
    {
        $event = $request->event ?? 'EVN23';

        if($request->logged_user_id){
            $user = User::find($request->logged_user_id);
        } else {
            $user = User::whereEmail($request->email)
                ->first();
        }

        $payload = [
            "section"          => $event,
            "user_id"          => $user ? $user['id'] : null,
            "user_name"        => $request->user_name,
            "user_phone"       => $request->user_phone,
            "user_email"       => $request->user_email,
            "job_type_code"    => null,
            "subtotal"         => null,
            "voucher_code"     => null,
            "voucher_discount" => null,
            "discount_amount"  => null,
            "service_fee"      => null,
            "tax"              => null,
            "total"            => 0,
            "status"           => 200,
            "payment_method"   => null,
            "paid_at"          => null,
            "transfer_proof"   => null,
        ];

        // cek email sudah daftar
        $transaction = Transaction::whereUserEmail($request->email)
            ->whereSection($event)
            ->first();

        if($transaction){
            $this->response['message'] = "Sudah terdaftar dalam acara.";
            return $this->response;
        }



//        $transaction->update([
//            'number' => $event . prefix_zero($transaction->id),
//        ]);
    }
}
