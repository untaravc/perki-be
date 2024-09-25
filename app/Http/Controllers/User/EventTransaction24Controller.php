<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\System\EmailServiceController;
use App\Models\Event;
use App\Models\Price;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Voucher;
use Illuminate\Http\Request;

class EventTransaction24Controller extends BaseController
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
            ->whereSection('jcu24')
            ->whereJobTypeCode($job_type_code)
            ->get();

        $events = Event::whereSection('jcu24')
            ->whereIn('marker', ['symposium-jcu24', 'first-workshop-jcu24', 'second-workshop-jcu24'])
            ->withCount('transactions')
            ->orderBy('name')
            ->get();

        $symposium = $events->where('marker', 'symposium-jcu24')->first();

        $first_workshop = $events->where('marker', 'first-workshop-jcu24')->flatten();
        $second_workshop = $events->where('marker', 'second-workshop-jcu24')->flatten();

        $symposium_price = $prices->where('model_id', $symposium->id)->first();
        $symposium['price'] = $symposium_price['price'];

        foreach ($first_workshop as $first) {
            $first['quota'] = $first['quota'];
            $first['transactions_count'] = min($first['quota'], $first['transactions_count']);
            $first['available'] = $first['quota'] >  $first['transactions_count'];
        }

        foreach ($second_workshop as $second) {
            $second['quota'] = $second['quota'];
            $second['transactions_count'] = min($second['quota'], $second['transactions_count']);

            $second['available'] = $second['quota'] >  $second['transactions_count'];
        }

        $data['symposium'] = $symposium;

        if ($transaction->job_type_code !== "MHSA") {
            $data['first_workshop'] = $first_workshop;
            $data['second_workshop'] = $second_workshop;
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

    public function create_payment(Request $request)
    {
        $items = $request->items;
        $pricing = $this->calculate_price($request)['result'];

        $transaction = Transaction::find($pricing['transaction']['id']);

        $transaction_payload = [
            'subtotal'         => $pricing['subtotal'],
            'voucher_code'     => $pricing['voucher_code'],
            'voucher_discount' => $pricing['voucher_discount'],
            'discount_amount'  => $pricing['discount_amount'],
            'package_discount' => $pricing['package_discount'],
            'total'            => $pricing['total'],
            'status'           => 110,
            'payment_method'   => 'manual_transfer',
            'plataran_img'     => $request->props['plataran_img'],
            'payment_method'   => 'manual_transfer',
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

        if ($request->users) {
            $this->record_child_transaction($transaction, $request->users);
        }

        // delete unused
        TransactionDetail::whereTransactionId($transaction->id)
            ->whereNotIn('event_id', $item_ids)
            ->delete();

        try {
            $email_service = new EmailServiceController();
            $email_service->bill($transaction->id);
        } catch (\Exception $e) {
        }

        $this->sendPostResponse();
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
                $data[] = $this->get_symposium($items['symposium'], $transaction, $force_price);
            } else {
                $data[] = $this->get_symposium($items['symposium'], $transaction);
            }
        }

        if (isset($items['first_workshop'])) {
            $data[] = $this->get_symposium($items['first_workshop'], $transaction);
        }
        if (isset($items['second_workshop'])) {
            $data[] = $this->get_symposium($items['second_workshop'], $transaction);
        }

        $package_discount = 0;
        $subtotal = collect($data)->sum('price');
        if (isset($items['second_workshop']) && isset($items['first_workshop'])) {
            $second = $data[2];
            if (isset($second['price'])) {
                $package_discount = $second['price'];
            }
        }
        $total = $subtotal - $package_discount;

        $voucher_discount = $this->calculate_discount($data, $request->voucher, $transaction->job_type_code);

        if ($voucher_discount['discount_amount'] > 0) {
            // $total = $subtotal;
            $total -= $voucher_discount['discount_amount'];
        }

        $this->response['result'] = [
            "transaction"        => $transaction,
            "items"              => $data,
            "subtotal"           => $subtotal,
            "voucher_code"       => $voucher_discount['voucher'],
            "voucher_validation" => $voucher_discount['voucher_validation'],
            "voucher_discount"   => $voucher_discount['voucher_discount'],
            "discount_amount"    => $voucher_discount['discount_amount'],
            "package_discount"   => $package_discount,
            "total"              => $total,
        ];

        return $this->response;
    }

    protected function calculate_discount($data, $voucher_code, $job_type_code = 'DRGN')
    {
        if (!$voucher_code) {
            return [
                "voucher"            => '',
                "voucher_discount"   => 0,
                "discount_amount"    => 0,
                "voucher_validation" => '',
            ];
        }

        $voucher = Voucher::whereCode($voucher_code)
            ->first();

        if (!$voucher) {
            return [
                "voucher"            => '',
                "voucher_discount"   => 0,
                "discount_amount"    => 0,
                "voucher_validation" => 'Invalid Voucher Code.',
            ];
        }

        $slugs = explode(',', $voucher->role);
        $voucher_included = 'true';
        foreach ($data as $datum) {
            if (!in_array($datum['slug'], $slugs)) {
                $voucher_included = 'false ' . $datum['marker'];
            }
        }

        if (!$voucher_included) {
            return [
                "voucher"            => '',
                "voucher_discount"   => 0,
                "discount_amount"    => 0,
                "voucher_validation" => 'Event not selected.',
            ];
        }

        if ($voucher->job_type_scope != null) {
            $job_type_scopes = explode(',', $voucher->job_type_scope);

            if (!in_array($job_type_code, $job_type_scopes)) {
                return [
                    "voucher"            => '',
                    "voucher_discount"   => 0,
                    "discount_amount"    => 0,
                    "voucher_validation" => 'Invalid Job Type',
                ];
            }
        }

        if ($voucher->qty != 0) {
            $used_voucher = Transaction::where('voucher_code', $voucher_code)
                ->count();

            if ($used_voucher >= $voucher->qty) {
                return [
                    "voucher"            => $voucher_code,
                    "voucher_discount"   => 0,
                    "discount_amount"    => 0,
                    "voucher_validation" => 'Voucher Out of Stock',
                ];
            }
        }

        $discount_amount = 0;
        $events = Event::whereIn('slug', $slugs)->get();

        foreach ($slugs as $slug) {
            $applied = collect($data)->pluck('slug')->toArray();
            if (in_array($slug, $applied)) {
                $event = $events->where('slug', $slug)->first();
                $price = Price::whereModelId($event['id'])
                    ->whereJobTypeCode($job_type_code)
                    ->first();
                if (!$price) {
                    $price = Price::whereModelId($event['id'])
                        ->whereJobTypeCode('DRGN')
                        ->first();
                }
                if ($voucher->type == 'amount') {
                    $discount_amount += $voucher->value;
                } else if ('percent') {
                    $discount_amount += $price['price'] * ($voucher->value / 100);
                }
            }
        }

        return [
            "voucher"            => $voucher_code,
            "voucher_discount"   => $voucher->value,
            "discount_amount"    => $discount_amount,
            "voucher_validation" => '',
        ];
    }

    private function get_symposium($symposium_id, Transaction $transaction, $force_price = null)
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

    protected function record_child_transaction(Transaction $transaction, $users)
    {
        $validate_users = 0;

        foreach ($users as $user) {
            if ($user['email'] != '' && $user['name'] != '' && $user['nik'] != '') {
                $validate_users++;
            }
        }

        if ($validate_users < 5) {
            return '';
        }

        $trx_child_ids = [];
        foreach ($users as $user) {
            if (!isset($user['id'])) {
                $payload = [
                    "section"          => "jcu24",
                    "number"           => $this->generate_child_number($transaction->number),
                    "parent_id"        => $transaction->id,
                    "user_id"          => $transaction->id,
                    "user_name"        => $user['name'],
                    "user_phone"       => null,
                    "user_email"       => $user['email'],
                    "job_type_code"    => "DRGN",
                    "nik"              => $user['nik'],
                    "subtotal"         => 0,
                    "voucher_code"     => 0,
                    "voucher_discount" => 0,
                    "discount_amount"  => 0,
                    "service_fee"      => 0,
                    "service_fee"      => 0,
                    "tax"              => 0,
                    "total"            => 0,
                    "status"           => 110,
                    "payment_method"   => "manual_transfer",
                ];

                $trx_child = Transaction::create($payload);
                $trx_child_ids[] = $trx_child->id;

                $payload_detail = [
                    "section"        => "jcu24",
                    "transaction_id" => $trx_child->id,
                    "job_type_code"  => $payload['job_type_code'],
                    "user_id"        => $payload['user_id'],
                    "event_id"       => 1,
                    "event_name"     => "Symposium",
                    "price"          => 1000000,
                    "status"         => 110,
                ];

                TransactionDetail::create($payload_detail);
            } else {
                $trx_child_ids[] = $user['id'];
            }
        }

        // delete unused
        Transaction::whereUserId($transaction->user_id)
            ->whereParentId($transaction->id)
            ->whereNotIn("id", $trx_child_ids)
            ->delete();
    }

    protected function generate_child_number($parent_number, $add = 1)
    {
        $parent = Transaction::where('number', 'LIKE', $parent_number . "%")->count();

        $number = $parent_number . '-' . $parent;
        $exist = Transaction::whereNumber($number)->first();

        if ($exist) {
            return $this->generate_child_number($parent_number, $add + 1);
        }

        return $number;
    }
}
