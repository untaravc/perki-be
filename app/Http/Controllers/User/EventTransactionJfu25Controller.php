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
use App\Models\Voucher;
use Illuminate\Http\Request;

class EventTransactionJfu25Controller extends BaseController
{
    public function event_list(Request $request)
    {
        $transaction = Transaction::whereNumber($request->transaction_number)
            ->with(['users', 'transaction_details'])
            ->first();

        if (!$transaction) {
            $this->sendError(422, 'Transaction number required.');
        }

        switch ($transaction->job_type_code) {
            case 'DRSP':
            case 'PRKI':
                $job_type_code = 'DRSP';
                break;
            default:
                $job_type_code = 'DRGN';
        }

        $prices = Price::whereModel('event')
            ->whereSection('jfu25')
            ->whereJobTypeCode($job_type_code)
            ->get();

        $events = Event::whereSection('jfu25')
            ->whereIn('marker', ['symposium-jfu25', 'workshop-jfu25'])
            ->withCount('transactions')
            ->orderBy('name')
            ->get();

        $symposium = $events->where('marker', 'symposium-jfu25')->first();

        $workshop = $events->where('marker', 'workshop-jfu25')
            ->where('slug', 'workshop-jfu25-1')
            ->flatten();

        $symposium_price = $prices->where('model_id', $symposium->id)->first();
        $symposium['price'] = $symposium_price['price'];

        foreach ($workshop as $first) {
            $first['transactions_count'] = min($first['quota'], $first['transactions_count']);
            $first['available'] = $first['quota'] >  $first['transactions_count'];
        }

        $data['symposium'] = $symposium;

        $data['workshop'] = $workshop;

        $this->response['result'] = [
            'items'         => $data,
            'transaction'   => $transaction,
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
                if ($user['email'] != '' && $user['name'] != '') {
                    $count++;
                }
            }
        }

        // $data[] = $this->get_symposium($items['symposium'], $transaction);
        if (isset($items['symposium'])) {
            if ($count > 0) {
                $data[] = $this->get_event($items['symposium'], $transaction, $count);
            } else {
                $data[] = $this->get_event($items['symposium'], $transaction);
            }
        }

        if (isset($items['workshop'])) {
            $data[] = $this->get_event($items['workshop'], $transaction);
        }

        $package_discount = 0;
        if($items['workshop'] != null && $items['symposium'] != null){
            $package_discount = 100000;
        }
        $subtotal = collect($data)->sum('price');

        $total = $subtotal - $package_discount;

        $voucher_discount = $this->calculate_discount($data, $request->voucher, $transaction->job_type_code);

        if ($voucher_discount['discount_amount'] > 0) {
            $total = $subtotal - $package_discount;
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

    private function get_event($symposium_id, Transaction $transaction, $multiply = 1)
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
            'price'  => $price['price'] * $multiply
        ];
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

            $fonnte = new FonnteServiceController();
            $fonnte->generateMessage($transaction);
        } catch (\Exception $e) {
        }

        $this->sendPostResponse();
    }

    protected function record_child_transaction(Transaction $transaction, $users)
    {
        $validate_users = 0;
        $valid_users = [];

        foreach ($users as $user) {
            if ($user['email'] != '' && $user['name'] != '' && $user['nik'] != '') {
                $validate_users++;
                $valid_users[] = $user;
            }
        }

        if ($validate_users < 1) {
            return '';
        }

        $trx_child_ids = [];
        foreach ($valid_users as $valid_user) {
            $model_user = User::whereEmail($valid_user['email'])
                ->first();
            if (!isset($valid_user['id'])) {
                $payload = [
                    "section"          => "jfu25",
                    "number"           => $this->generate_child_number($transaction->number),
                    "parent_id"        => $transaction->id,
                    "user_id"          => $model_user ? $model_user->id : 0,
                    "user_name"        => $valid_user['name'],
                    "user_phone"       => null,
                    "user_email"       => $valid_user['email'],
                    "job_type_code"    => "DRGN",
                    "nik"              => $valid_user['nik'],
                    "subtotal"         => 0,
                    "voucher_code"     => 0,
                    "voucher_discount" => 0,
                    "discount_amount"  => 0,
                    "service_fee"      => 0,
                    "tax"              => 0,
                    "total"            => 0,
                    "status"           => 110,
                    "payment_method"   => "manual_transfer",
                ];

                $trx_child = Transaction::create($payload);
                $trx_child_ids[] = $trx_child->id;

                $payload_detail = [
                    "section"        => "jfu25",
                    "transaction_id" => $trx_child->id,
                    "job_type_code"  => $payload['job_type_code'],
                    "user_id"        => $payload['user_id'],
                    "event_id"       => 294,
                    "event_name"     => "Symposium",
                    "price"          => 250000,
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
                ->where('status', '<', 300)
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
}
