<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventUser;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventPresenceController extends Controller
{
    public function index(Request $request)
    {
        $data_content = EventUser::orderByDesc('updated_at')
            ->with('scanner', 'event');

        $data_content = $this->withFilter($data_content, $request);
        $data_content = $data_content->paginate($request->per_page ?? 25);

        foreach ($data_content as $data) {
            $transaction_detail = TransactionDetail::whereUserId($data->user_id)
                ->whereIn('event_id', [20, 21, 22, 23, 68, 72, 76, 80])
                ->first();

            if ($transaction_detail) {
                $data->setAttribute('has_ws', true);
            } else {
                $data->setAttribute('has_ws', false);
            }
        }

        $collect = collect($this->response);
        return $collect->merge($data_content);
    }

    public function withFilter($data_content, $request)
    {
        if ($request->scanner_id) {
            $data_content = $data_content->where('scanner_id', $request->scanner_id);
        }

        if ($request->event_id) {
            $data_content = $data_content->where('event_id', $request->event_id);
        }

        if ($request->status) {
            $data_content = $data_content->where('status', $request->status);
        }

        if ($request->name) {
            $data_content = $data_content->where('user_name', "LIKE", "%" . $request->name . "%");
        }
        return $data_content;
    }

    public function update($id, Request $request)
    {
        $event_user = EventUser::find($id);

        if ($event_user) {
            $event_user->update([
                'status' => 200
            ]);
        }

        return $this->response;
    }

    public function check_qrcode_data(Request $request)
    {
        return $this->validateRequest($request);
    }

    public function record_qrcode_data(Request $request)
    {
        $result = $this->validateRequest($request);

        if (!$result['success']) {
            return $result;
        }

        $transaction = $result['result']['transaction'];
        $transaction_detail = $result['result']['transaction_detail'];

        $payload = [
            "scanner_id"            => (int)$request->admin_id,
            "transaction_detail_id" => $transaction_detail->id,
            "transaction_id"        => $transaction->id,
            "user_id"               => $transaction->user_id,
            "user_name"             => $transaction->user_name,
            "user_email"            => $transaction->user_email,
            "event_id"              => $transaction_detail->event_id,
            "status"                => 100,
            "hits"                  => 1,
        ];

        $event_user = EventUser::whereTransactionId($payload['transaction_id'])
            ->whereUserId($payload['user_id'])
            ->whereEventId($payload['event_id'])
            ->first();

        if ($event_user) {
            $event_user->update([
                'hits' => $event_user->hits + 1
            ]);
            $this->response['message'] = "Sudah presensi.";
            return $this->response;
        }

        EventUser::create($payload);

        $this->response['message'] = "Berhasil Presensi.";
        return $this->response;
    }

    private function validateRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'     => 'required',
            // 'admin_id' => 'required',
            'event_id' => 'required',
        ]);

        if ($validator->fails()) {
            $this->response['success'] = false;
            $this->response['message'] = "Invalid Parameters";
            return $this->response;
        }

        // $user = User::whereType('room')
        //     ->find($request->admin_id);
        // if (!$user) {
        //     $this->response['success'] = false;
        //     $this->response['message'] = "Invalid parameters: Admin";
        //     return $this->response;
        // }

        $event = Event::where('data_type', 'product')->find($request->event_id);

        if (!$event) {
            $this->response['success'] = false;
            $this->response['message'] = "Invalid parameters: Event";
            return $this->response;
        }

        $transaction = Transaction::whereNumber($request->code)
            ->first();

        if (!$transaction) {
            $this->response['success'] = false;
            $this->response['message'] = "Kode Tidak Sesuai!";
            return $this->response;
        }

        $transaction_detail = TransactionDetail::whereTransactionId($transaction->id)
            ->whereEventId($event->id)
            ->whereStatus(200)
            ->first();

        if (!$transaction_detail) {
            $this->response['success'] = false;
            $this->response['message'] = "Peserta tidak terdaftar pada: " . $event->name;
            return $this->response;
        }

        $data['transaction'] = $transaction;
        $data['transaction_detail'] = $transaction_detail;

        $this->response['result'] = $data;
        return $this->response;
    }

    public function scan_params()
    {
        $data['events'] = Event::whereDataType('product')
            ->orderBy('name')
            ->whereStatus(1)
            ->get();

        $data['admin'] = User::whereType('room')
            ->get();

        $this->response['result'] = $data;
        return $this->response;
    }

    public function print_event_presence($event_user_id)
    {
        $event_user = EventUser::find($event_user_id);

        if (!$event_user) {
            return 'not found';
            //
            //            $trx = Transaction::find($event_user_id);
            //
            //            if($trx){
            //                $event_user['user_name'] = $trx['user_name'];
            //            }else{
            //            }
        }

        return view('print.event_user.nametag', compact('event_user'));
    }

    public function print_transaction_presence($transaction_id)
    {
        $event_user = Transaction::find($transaction_id);
        if (!$event_user) {
            return 'not found';
        }

        return view('print.event_user.nametag', compact('event_user'));
    }
}
