<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\System\EmailServiceController;
use App\Models\Event;
use App\Models\Post;
use App\Models\Price;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

        if ($bundle == 2 && (now() < "2023-07-31")) {
            if ($job_type_code == 'DRSP') {
                $bundle_price = DRSP_BUNDLE_PRICE;
            } else {
                $bundle_price = DRGN_BUNDLE_PRICE;
            }
        }

        $discount = isset($bundle_price) ? - ($subtotal - $bundle_price) : 0;

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
        $this->response['success'] = false;
        $this->response['message'] = "Registration on review. Will be available in the next few days.";
        return $this->response;

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
            ->with([
                'transaction_details' => function ($q) {
                    $q->with('event');
                },
                'users'
            ])
            ->whereUserId($user['id'])
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
            ->orderByDesc('id')
            ->when($request->ref, function ($q) use ($request) {
                $q->whereSection($request->ref);
            })
            ->where('status', '<', 300)
            ->with(['transaction_details' => function ($q) {
                $q->with('event');
            }, 'transaction_children'])
            ->get();

        $this->response['result'] = $data;
        return $this->response;
    }

    public function transfer_proof(Request $request)
    {
        $user = $request->user();

        $transaction = Transaction::whereUserId($user['id'])
            ->find($request->transaction_id);

        if (!$transaction) {
            $this->sendError(404);
        }

        $discord_wh_url = env("DISCORD_WH_URL");
        if($request->transfer_proof_link){
            $transaction->update([
                'transfer_proof' => $request->transfer_proof_link,
                'status'         => 120,
            ]);
        }

        if($request->transfer_proof_gl_link){
            $transaction->update([
                'transfer_proof_gl' => $request->transfer_proof_gl_link,
                'status'         => 119,
            ]);
        }

        if($discord_wh_url) {
            try{
                Http::post($discord_wh_url, [
                    "content" => "[" . date('H:i:s') . "] New Transaction:  " . $transaction->user_name . " - Rp " . number_format($transaction->total, 0, ',', '.'),
                ]);
            } catch (\Exception $e){}
        }

        return $this->response;
    }

    public function pending_transaction_count(Request $request)
    {
        $user = $request->user();

        $data['pending_transaction'] = Transaction::whereUserId($user['id'])
            ->when($request->ref, function ($q) use ($request) {
                $q->whereSection($request->ref);
            })
            ->where('status', '<', 200)
            ->count();

        $data['abstracts'] = Post::whereUserId($user['id'])
            ->whereIn('category', [
                'case_report',
                'case_report_sp',
                'research',
                'research_sp',
                'systematic_review',
            ])
            ->when($request->section, function ($q) use ($request) {
                $q->whereSection($request->section);
            })
            ->count();

        $this->response['result'] = $data;


        return $this->response;
    }

    public function event_list_2(Request $request)
    {
        $transaction = Transaction::whereNumber($request->transaction_number)
            ->with('users')
            ->first();

        if (!$transaction) {
            $this->sendError(422, 'Transaction number required.');
        }

        $job_type_code = $transaction->job_type_code === 'DRSP' ? 'DRSP' : 'DRGN';

        $prices = Price::whereModel('event')
            ->whereSection('jcu23')
            ->whereJobTypeCode($job_type_code)
            ->get();

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
                'date_end',
            )->first();

        $symposium_price = $prices->where('model_id', $symposium->id)->first();
        $symposium['price'] = $symposium_price['price'];

        // Morning workshop
        $morning_workshop = Event::whereSection('jcu23')
            ->withCount('transactions')
            ->whereMarker('workshop-jcu23-half-day-1')
            ->orderBy('name')
            ->get();

        foreach ($morning_workshop as $morning) {
            $price = $prices->where('model_id', $morning->id)->first();
            $morning->setAttribute('price', $price['price']);

            $available = $morning->quota > $morning->transactions_count;
            $morning->setAttribute('available', $available);
        }

        // Afternoon workshop
        $afternoon_workshop = Event::whereSection('jcu23')
            ->withCount('transactions')
            ->whereMarker('workshop-jcu23-half-day-2')
            ->orderBy('name')
            ->get();

        foreach ($afternoon_workshop as $afternoon) {
            $price = $prices->where('model_id', $afternoon->id)->first();
            $afternoon->setAttribute('price', $price['price']);

            $available = $afternoon->quota > $afternoon->transactions_count;
            $afternoon->setAttribute('available', $available);
        }

        $data['symposium'] = $symposium;
        $data['morning_workshop'] = $morning_workshop;
        $data['afternoon_workshop'] = $afternoon_workshop;

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

    public function calculate_price_2(Request $request)
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

        if ($request->package !== 'add-on') {
            if (isset($items['symposium'])) {
                if ($count >= 5) {
                    $force_price = $transaction->job_type_code === 'DRSP' ? 7500000 : 5000000;
                    $data[] = $this->get_symposium($items['symposium'], $transaction, $force_price);
                } else {
                    $data[] = $this->get_symposium($items['symposium'], $transaction);
                }
            }
        }

        if (isset($items['morning_workshop'])) {
            $data[] = $this->get_symposium($items['morning_workshop'], $transaction);
        }

        if (isset($items['afternoon_workshop'])) {
            $data[] = $this->get_symposium($items['afternoon_workshop'], $transaction);
        }

        // platinum
        if ($request->package == 'platinum') {
            $package_discount = 0;
            if (isset($items['morning_workshop']) && isset($items['afternoon_workshop'])) {
                $package_discount = 250000;
                if (now() < '2023-08-01 00:00:00') {
                    $package_discount = 500000;
                }
            }

            $subtotal = collect($data)->sum('price');
            $total = $subtotal - $package_discount;
        } else {
            $package_discount = 0;
            $subtotal = collect($data)->sum('price');
            $total = $subtotal - $package_discount;
        }

        $voucher_discount = $this->calculate_discount($data, $request->voucher, $transaction->job_type_code);

        if ($voucher_discount['discount_amount'] > 0) {
            $package_discount = 0;
            $total = $subtotal;
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

    public function create_payment_2(Request $request)
    {
        $items = $request->items;
        switch ($request->package) {
            case 'platinum':
                if (!$items['symposium'] || !$items['morning_workshop'] || !$items['afternoon_workshop']) {
                    $this->sendError(422, "Please select workshop!");
                }
                break;
            case 'add-on':
                if (!$items['morning_workshop'] || !$items['afternoon_workshop']) {
                    //                    $this->sendError(422, "Please select two workshops!");
                }
                break;
            case 'gold':
                if (!$items['symposium']) {
                    $this->sendError(422, "Please select symposium!");
                }
                break;
        }

        $pricing = $this->calculate_price_2($request)['result'];

        $transaction = Transaction::find($pricing['transaction']['id']);

        $transaction_payload = [
            'subtotal'         => $pricing['subtotal'],
            'voucher_code'     => $pricing['voucher_code'],
            'voucher_discount' => $pricing['voucher_discount'],
            'discount_amount'  => $pricing['discount_amount'],
            'total'            => $pricing['total'],
            'status'           => 110,
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

        //        return $item_ids;
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

    protected function record_child_transaction(Transaction $transaction, $users)
    {
        $validate_users = 0;

        foreach ($users as $user) {
            if ($user['email'] != '' && $user['name'] != '') {
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
                    "section"          => "jcu23",
                    "number"           => $this->generate_child_number($transaction->number),
                    "parent_id"        => $transaction->id,
                    "user_id"          => $transaction->id,
                    "user_name"        => $user['name'],
                    "user_phone"       => null,
                    "user_email"       => $user['email'],
                    "job_type_code"    => "DRGN",
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
                    "section"        => "jcu23",
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

    public function update_transaction_name(Request $request)
    {
        $trx = Transaction::find($request->id);

        if ($trx) {
            $trx->update([
                'user_name' => $request->user_name
            ]);
        }

        return $this->response;
    }
}
