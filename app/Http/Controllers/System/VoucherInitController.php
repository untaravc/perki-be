<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherInitController extends Controller
{
    public function voucher_init()
    {
        $data = [
            [
                "name"     => "Free Symposium",
                "code"     => "FRSY001",
                "role"     => "symposium-jcu23",
                "type"     => "percent",
                "value"    => 100,
                "qty"      => 1,
                "qty_rest" => 0,
                "status"   => 1,
            ],
            [
                "name"     => "Discount Symposium",
                "code"     => "DISCSY20",
                "role"     => "symposium-jcu23",
                "type"     => "percent",
                "value"    => 20,
                "qty"      => 2,
                "qty_rest" => 0,
                "status"   => 1,
            ],
            [
                "name"     => "Discount Amount",
                "code"     => "DC300K",
                "role"     => "symposium-jcu23,workshop-jcu23-half-day",
                "type"     => "amount",
                "value"    => 300000,
                "qty"      => 2,
                "qty_rest" => 0,
                "status"   => 1,
            ],
            [
                "name"     => "Discount Percent",
                "code"     => "DC10P",
                "role"     => "symposium-jcu23,workshop-jcu23-half-day",
                "type"     => "percent",
                "value"    => 10,
                "qty"      => 2,
                "qty_rest" => 0,
                "status"   => 1,
            ],
        ];

        foreach ($data as $item) {
            $job_type = Voucher::whereCode($item['code'])->first();

            if ($job_type) {
                $job_type->update($item);
            } else {
                Voucher::create($item);
            }
        }
    }
}
