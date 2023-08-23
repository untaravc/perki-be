<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventUser;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * 200 : first scan
     * 201 : rescan
     * 300 : printed
     * 400 : event not registered
     */
    public function scan_event(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number'   => "required",
            'event_id' => "required",
        ]);

        if($validator->fails()){
            return $this->response(422, 'Data tidak ditemukan. ERR01');
        }

        $transaction = Transaction::whereNumber($request->number)
            ->first();

        if (!$transaction) {
            return $this->response(422, 'Data tidak ditemukan. ERR02');
        }

        // record
        $scanner = $request->user();

        // check transaction detail
        $transaction_details = TransactionDetail::whereTransactionId($transaction->id)
            ->where('event_id', $request->event_id)
            ->first();

        if (!$transaction_details) {
            return $this->response(422, 'Peserta tidak terdaftat ke acara');
        }

        $status_code = 200;

        // cek sudah login
        $event_user = EventUser::whereUserId($transaction['user_id'])
            ->whereEventId($request->event_id)
            ->first();

        if($event_user){
            $message = "Peserta sudah pernah scan barcode.";
            $status_code = 201;
        }

        $payload = [
            "scanner_id" => $scanner['id'],
            "user_id"    => $transaction['user_id'],
            "event_id"   => $request->event_id,
            "status"     => $status_code,
        ];

        if(!$event_user){
            $event_user = EventUser::create($payload);
            $message = "Berhasil scan peserta.";
        } else {
            $event_user->update($payload);
        }

        if($event_user['status'] == 300){
            $message = "Peserta sudah print data.";
        }

        // return data
        $this->response['message'] = $message;
        $this->response['result'] = $event_user;
        return $this->response;
    }

    public function event_member($slug){
        $exclude_user_ids = [182];
        $event = Event::whereSlug($slug)->first();

        if(!$event){
            return abort(404);
        }

        $transaction_details = TransactionDetail::whereEventId($event->id)
            ->whereHas('transaction')
            ->with('transaction')
            ->orderByRaw("FIELD(status, 200) DESC")
            ->orderBy('created_at')
            ->whereNotIn('user_id', $exclude_user_ids)
            ->where('status', '!=', 400)
            ->get();

        return view('print.event_user.list', compact('event', 'transaction_details'));
    }
}
