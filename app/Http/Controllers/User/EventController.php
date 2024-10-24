<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Models\Event;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

const EVENT_ID = [
    // 80, //
    111, // Sympo
    213, // WS 1
    217, // WS 2
    221, // WS 3
    225, // WS 4
    229, // WS 5
    233, // WS 6
    237, // WS 7
    242, // WS 8
];

class EventController extends BaseController
{
    public function index(Request $request)
    {
        $dataContent = Event::orderByDesc('name')->whereIn('id', EVENT_ID);
        $dataContent = $this->withFilter($dataContent, $request);
        $dataContent = $dataContent->paginate($request->per_page ?? 20);

        $result = collect($this->response);
        return $result->merge($dataContent);
    }

    public function withFilter($dataContent, $request)
    {
        if ($request->name) {
            $dataContent = $dataContent->where('name', 'LIKE', '%' . $request->name . '%');
        }
        // if ($request->event_id) {
        //     $dataContent = $dataContent->where('id', $request->event_id);
        // }
        return $dataContent;
    }

    public function event_schedule(Request $request)
    {
        $user = $request->user();

        $transaction_details = TransactionDetail::whereUserId($user['id'])
            ->whereHas('transaction', function ($q) {
                $q->where('status', 200);
            })
            ->with('event')
            ->get();

        $this->response['result'] = $transaction_details;
        return $this->response;
    }
}
