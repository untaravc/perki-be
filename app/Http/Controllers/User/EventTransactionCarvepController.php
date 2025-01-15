<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\System\EmailServiceController;
use App\Http\Controllers\System\FonnteServiceController;
use App\Models\Event;
use App\Models\Price;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Http\Request;

class EventTransactionCarvepController extends BaseController
{
    public function event_list(Request $request)
    {
        $transaction = Transaction::whereNumber($request->transaction_number)
            ->with(['users', 'transaction_details'])
            ->first();

        if (!$transaction) {
            $this->sendError(422, 'Transaction number required.');
        }

        $job_type_code = 'DRGN';

        switch ($transaction->job_type_code) {
            case 'DRSP':
            case 'PRKI':
                $job_type_code = 'DRSP';
                break;
            case 'MHSA':
                $job_type_code = "MHSA";
                break;
            default:
                $job_type_code = 'DRGN';
        }

        $prices = Price::whereModel('event')
            ->whereSection('carvep')
            ->whereJobTypeCode($job_type_code)
            ->get();

        $events = Event::whereSection('carvep')
            ->whereIn('marker', ['symposium-carvep', 'workshop-carvep'])
            ->withCount('transactions')
            ->orderBy('name')
            ->get();

        $symposium = $events->where('marker', 'symposium-carvep')->first();

        if($job_type_code === 'DRSP'){
            $workshop = $events->where('marker', 'workshop-carvep')->where('slug', 'workshop-carvep-1')->flatten();
        } else {
            $workshop = $events->where('marker', 'workshop-carvep')->where('slug', 'workshop-carvep-2')->flatten();
        }

        $symposium_price = $prices->where('model_id', $symposium->id)->first();
        $symposium['price'] = $symposium_price['price'];

        foreach ($workshop as $first) {
            $first['transactions_count'] = min($first['quota'], $first['transactions_count']);
            $first['available'] = $first['quota'] >  $first['transactions_count'];
        }

        $data['symposium'] = $symposium;

        if ($transaction->job_type_code !== "MHSA") {
            $data['workshop'] = $workshop;
        }

        // has symposium
        $trx_symposium = TransactionDetail::whereUserId($transaction->user_id)
            ->whereEventId($symposium->id)
            ->first();

        if ($trx_symposium) {
            $has_symposium = true;
        } else {
            $has_symposium = false;
        }

        $this->response['result'] = [
            'items'         => $data,
            'transaction'   => $transaction,
            'has_symposium' => $has_symposium,
        ];
        return $this->response;
    }

    public function calculate_price(Request $request)
    {
        $user = $request->user();
        $data = [];
        $transaction = Transaction::whereNumber($request->transaction_number)
            ->whereUserId($user['id'])
            ->first();

        if (!$transaction) {
            $this->sendError(422, 'Transaction not found.');
        }

        $items = $request->items;

        $additional_user = collect($request->users);
        $count = 0;
        foreach ($additional_user as $user) {
            if ($user['email'] != null && $user['name'] != null) {
                $count++;
            }
        }

        // $data[] = $this->get_symposium($items['symposium'], $transaction);
        if (isset($items['symposium'])) {
            if ($count >= 5) {
                $force_price = $transaction->job_type_code === 'DRSP' ? 1000000 : 5000000;
                $data[] = $this->get_event($items['symposium'], $transaction, $force_price);
            } else {
                $data[] = $this->get_event($items['symposium'], $transaction);
            }
        }

        if (isset($items['workshop'])) {
            $data[] = $this->get_event($items['workshop'], $transaction);
        }

        $package_discount = 0;
        $subtotal = collect($data)->sum('price');
//        if (isset($items['second_workshop']) && isset($items['first_workshop'])) {
//            $second = $data[2];
//            if (isset($second['price'])) {
//                $package_discount = $second['price'];
//            }
//        }
        $total = $subtotal - $package_discount;

//        $voucher_discount = $this->calculate_discount($data, $request->voucher, $transaction->job_type_code);

//        if ($voucher_discount['discount_amount'] > 0) {
//            // $total = $subtotal;
//            $total -= $voucher_discount['discount_amount'];
//        }

        $this->response['result'] = [
            "transaction"        => $transaction,
            "items"              => $data,
            "subtotal"           => $subtotal,
//            "voucher_code"       => $voucher_discount['voucher'],
//            "voucher_validation" => $voucher_discount['voucher_validation'],
//            "voucher_discount"   => $voucher_discount['voucher_discount'],
//            "discount_amount"    => $voucher_discount['discount_amount'],
            "package_discount"   => $package_discount,
            "total"              => $total,
        ];

        return $this->response;
    }

    private function get_event($symposium_id, Transaction $transaction, $force_price = null)
    {
        $event = Event::find($symposium_id);

        if (!$event) {
            $this->sendError(422, "Simposium tidak sesuai.");
        }

        $job_type_code = job_type_code_map($transaction->job_type_code);

        $price = Price::whereJobTypeCode($job_type_code)
            ->whereModel('event')
            ->whereModelId($symposium_id)
            ->first();

        if (!$price) {
            $this->sendError(422, "Harga simposium tidak ada.");
        }

        return [
            'name'   => $event->name,
            'marker' => $event->marker,
            'slug'   => $event->slug,
            'price'  => $force_price != null ? $force_price : $price['price']
        ];
    }

    public function create_payment(Request $request)
    {
        $items = $request->items;
        $pricing = $this->calculate_price($request)['result'];

        $transaction = Transaction::find($pricing['transaction']['id']);

        $transaction_payload = [
            'subtotal'         => $pricing['subtotal'],
//            'voucher_code'     => $pricing['voucher_code'],
//            'voucher_discount' => $pricing['voucher_discount'],
//            'discount_amount'  => $pricing['discount_amount'],
            'package_discount' => $pricing['package_discount'],
            'total'            => $pricing['total'],
            'status'           => 110,
            'payment_method'   => 'manual_transfer',
            'plataran_img'     => $request->props['plataran_img'],
        ];

        $transaction->update($transaction_payload);

        $item_ids = [];
        foreach ($items as $item) {
            if ($item) {
                $item_ids[] = $item;
            }
            $transaction_detail = TransactionDetail::whereTransactionId($transaction->id)
                ->whereEventId($item)
                ->first();

            $event = Event::find($item);
            if ($event) {
                $price = Price::whereModel('event')
                    ->whereModelId($item)
                    ->whereJobTypeCode($transaction->job_type_code)
                    ->first();

                if (!$price) {
                    $price = Price::whereModel('event')
                        ->whereModelId($item)
                        ->whereJobTypeCode('DRGN')
                        ->first();
                }

                if (!$transaction_detail) {
                    TransactionDetail::create([
                        "section"        => $transaction->section,
                        "transaction_id" => $transaction->id,
                        "job_type_code"  => $transaction->job_type_code,
                        "user_id"        => $transaction->user_id,
                        "event_id"       => $item,
                        "event_name"     => $event->name,
                        "price"          => $price ? $price['price'] : 0,
                        "status"         => $transaction->status,
                    ]);
                } else {
                    $transaction_detail->update([
                        "price"  => $price ? $price['price'] : 0,
                        "status" => $transaction->status,
                    ]);
                }
            }
        }

//        if ($request->users) {
//            $this->record_child_transaction($transaction, $request->users);
//        }

        // delete unused
        TransactionDetail::whereTransactionId($transaction->id)
            ->whereNotIn('event_id', $item_ids)
            ->delete();

        try {
            $email_service = new EmailServiceController();
            $email_service->bill($transaction->id);

            $fonnte = new FonnteServiceController();
            $fonnte->generateMessage($transaction);
        } catch (\Exception $e) {
        }

        $this->sendPostResponse();
    }
}
