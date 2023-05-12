<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Models\Event;
use App\Models\Price;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Voucher;
use Illuminate\Http\Request;

const DRSP_BUNDLE_PRICE = 3750000;
const DRGN_BUNDLE_PRICE = 1750000;

class EvenTransactionController extends BaseController
{
    public function event_list(Request $request)
    {
        $transaction = Transaction::whereNumber($request->transaction_number)->first();

        if (!$transaction) {
            $this->sendError(422, 'Transaction number required.');
        }

        $job_type_code = $transaction->job_type_code === 'DRSP' ? 'DRSP' : 'DRGN';

        $full_day = Event::whereSection('jcu23')
            ->whereMarker('workshop-jcu23-full-day')
            ->orderBy('name')
            ->select(
                'id',
                'name',
                'title',
                'marker',
                'slug',
                'date_start',
            )->get();

        $full_day_prices = Price::whereModel('event')
            ->whereSection('jcu23')
//            ->whereIn('model_id', $full_day->pluck('id')->toArray())
            ->whereJobTypeCode($job_type_code)
            ->get();

        foreach ($full_day as $full) {
            $price = $full_day_prices->where('model_id', $full->id)->first();
            $full->setAttribute('price', $price['price']);
        }

        $half_day = Event::whereSection('jcu23')
            ->whereMarker('workshop-jcu23-half-day')
            ->orderBy('name')
            ->select(
                'id',
                'name',
                'title',
                'marker',
                'slug',
                'date_start',
            )->get();

        $symposium = Event::whereSection('jcu23')
            ->whereMarker('symposium-jcu23')
            ->orderBy('name')
            ->select(
                'id',
                'name',
                'title',
                'marker',
                'slug',
                'date_start',
            )->first();

        $symposium_price = $full_day_prices->where('model_id', $symposium->id)->first();
        $symposium['price'] = $symposium_price['price'];

        $data['symposium'] = $symposium;
        $data['half_day'] = $half_day;
        $data['full_day'] = $full_day;

        $this->sendGetResponse($data);
    }

    public function calculate_price(Request $request)
    {
        $user = $request->user();
        $data = [];

        $transaction = Transaction::whereNumber($request->transaction_number)
            ->whereUserId($user['id'])
            ->first();

        if (!$transaction) {
            $this->sendError(422, 'Transaction number required.');
        }

        $job_type_code = $transaction->job_type_code === 'DRSP' ? 'DRSP' : 'DRGN';

        $items = $request->items;
        // calculate sympo
        if (isset($items['symposium'])) {
            $symposium = Event::whereMarker('symposium-jcu23')
                ->find($items['symposium']);

            if (!$symposium) {
                $this->sendError(422, "Simposium tidak sesuai.");
            }

            $price = Price::whereJobTypeCode($job_type_code)
                ->whereModel('event')
                ->whereModelId($items['symposium'])
                ->first();

            if (!$price) {
                $this->sendError(422, "Harga simposium tidak ada.");
            }

            $half_day = '';
            if (isset($items['workshop_half_day'])) {
                $half_day_event = Event::find($items['workshop_half_day']);
                if ($half_day_event) {
                    $half_day = ' & ' . $half_day_event['name'];
                }
            }

            $data['symposium'] = [
                'name'   => $symposium->name . $half_day,
                'marker' => $symposium->marker,
                'price'  => $price['price']
            ];
        }

        // calculate ws fd
        if (isset($items['workshop_full_day'])) {
            $wsfd = Event::whereMarker('workshop-jcu23-full-day')
                ->find($items['workshop_full_day']);

            if (!$wsfd) {
                $this->sendError(422, "Wokrshop fullday tidak sesuai.");
            }

            $price_ws = Price::whereJobTypeCode($job_type_code)
                ->whereModel('event')
                ->whereModelId($items['workshop_full_day'])
                ->first();

            if (!$price_ws) {
                $this->sendError(422, "Harga workshop fullday tidak ada.");
            }

            $data['workshop_full_day'] = [
                'name'   => $wsfd->name . ': ' . $wsfd->title,
                'marker' => $wsfd->marker,
                'price'  => $price_ws['price']
            ];
        }

        $bundle = 0;
        $subtotal = 0;
        foreach ($data as $item) {
            if (in_array($item['marker'], ['symposium-jcu23', 'workshop-jcu23-full-day'])) {
                $bundle++;
            }
            $subtotal += $item['price'];
        }

        if ($bundle == 2 && (now() < "2023-04-31")) {
            if ($job_type_code == 'DRSP') {
                $bundle_price = DRSP_BUNDLE_PRICE;
            } else {
                $bundle_price = DRGN_BUNDLE_PRICE;
            }
        }

        $discount = isset($bundle_price) ? -($subtotal - $bundle_price) : 0;

        $data['discount'] = [
            'name'   => "Bundle Discount",
            'marker' => "discount",
            'price'  => $discount,
        ];

        $data['total'] = [
            'name'   => "Total",
            'marker' => "total",
            'price'  => $subtotal + $discount,
        ];

        if ($request->voucher) {
            $data = $this->redeem_voucher($request, $data);
        }

        $this->response['result'] = [
            'items'       => $data,
            'count'       => $bundle,
            'transaction' => $transaction
        ];

        return $this->response;
    }

    private function redeem_voucher($request, $data)
    {
        $voucher = Voucher::whereCode($request->voucher)
//            ->where('qty_rest', '>', 0)
            ->where('status', 1)
            ->first();

        if (!$voucher) {
            $this->response['message'] = "Voucher Code not available";
            return $data;
        }

        // apakah voucher berlaku
        $active = 0;
        $subtotal = 0;
        $voucher_role = explode(',', $voucher->role);
        foreach ($data as $item) {
            if (in_array($item['marker'], $voucher_role)) {
                $active = 1;
                $subtotal += $item['price'];
            }
        }

        if ($active == 0) {
            $this->response['message'] = "Voucher Code not available";
            return $data;
        }

        if ($voucher->type == "percent") {
            $voucher_discount_amount = $subtotal * $voucher->value / 100;
        } else {
            $voucher_discount_amount = $voucher->value;
        }

        array_pop($data);

        $data["voucher_discount"] = [
            'name'   => "Discount Voucher: " . $request->voucher,
            'marker' => "discount-voucher",
            'price'  => -$voucher_discount_amount,
        ];

        $data['total'] = [
            'name'   => "Total",
            'marker' => "total",
            'price'  => collect($data)->sum('price'),
        ];

        $this->response['message'] = "Voucher Code activated";

        return $data;
    }

    public function create_payment(Request $request)
    {
        // validasi select halfday
        $items = $request->items;
        if ($items['symposium'] && $items['workshop_half_day'] == null) {
            $this->sendError(422, 'Silakan memilih Half Day Workshop');
        }

        $calculate_price = $this->calculate_price($request);
        $result = $calculate_price['result'];
        if ($result['count'] == 0) {
            $this->sendError(422, 'Silakan memilih Simposium & Workshop');
        }

        // update trx
        $transaction = Transaction::find($result['transaction']['id']);

        $items_collect = collect($result['items']);
        $voucher_discount = $items_collect->where('marker', 'discount-voucher')->first();
        $total = $items_collect->where('marker', 'total')->first();
        $discount = $items_collect->where('marker', 'discount')->first();
        $subtotal = $items_collect->whereIn('marker', ['symposium-jcu23', 'workshop-jcu23-full-day'])->sum('price');

        $transaction_payload = [
            'subtotal'         => $subtotal,
            'voucher_code'     => $voucher_discount ? $request->voucher : null,
            'voucher_discount' => $voucher_discount ? $voucher_discount['price'] : null,
            'discount_amount'  => $discount ? $discount['price'] : null,
            'total'            => $total['price'],
            'status'           => 110,
            'payment_method'   => 'manual_transfer',
        ];

        $transaction->update($transaction_payload);

        // create trx detail
        $item_ids = [];
        foreach ($items as $item) {
            $item_ids[] = $item;
            $transaction_detail = TransactionDetail::whereTransactionId($transaction->id)
                ->whereEventId($item)
                ->first();

            $event = Event::find($item);
            if ($event) {
                $price = Price::whereModel('event')
                    ->whereModelId($item)
                    ->whereJobTypeCode($transaction->job_type_code)
                    ->first();

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

        // delete unused
        TransactionDetail::whereTransactionId($transaction->id)
            ->whereNotIn('event_id', $item_ids)
            ->delete();

        $this->sendPostResponse();
    }

    public function show(Request $request, $transaction_number)
    {
        $user = $request->user();
        $data = Transaction::whereNumber($transaction_number)
            ->with('transaction_details')
//            ->whereUserId($user['id'])
            ->first();

        if (!$data) {
            $this->sendError(404);
        }

        $this->sendGetResponse($data);
    }

    public function transaction_list(Request $request)
    {
        $user = $request->user();

        $data = Transaction::whereUserId($user['id'])
            ->with('transaction_details')
            ->get();

        $this->response['result'] = $data;
        return $this->response;
    }

    public function transfer_proof(Request $request)
    {
        $user = $request->user();

        $transaction = Transaction::whereUserId($user['id'])
//            ->whereIn('status', [100,110])
            ->find($request->transaction_id);

        if (!$transaction) {
            $this->sendError(404);
        }

        $transaction->update([
            'transfer_proof' => $request->transfer_proof_link,
            'status'         => 120,
        ]);

        return $this->response;

    }

    public function pending_transaction_count(Request $request){
        $user = $request->user();

        $data['pending_transaction'] = Transaction::whereUserId($user['id'])
        ->where('status', '<', 200)
        ->count();

        $this->response['result'] = $data;
        return $this->response;
    }

}
