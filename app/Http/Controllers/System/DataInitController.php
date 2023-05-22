<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class DataInitController extends BaseController
{
    public function init(Request $request)
    {
        switch ($request->section) {
            case 'event':
                $event = new EventInitController();
                $event->event_init();
                break;
            default:
                return [
                    'message' => 'section required'
                ];
        }
        $speakers = new SpeakerInitController();
        $speakers->init_speaker();

        $user = new UserInitController();
        $user->user_init();

        $job_type = new JobTypeInitController();
        $job_type->job_type_init();

        $cat = new CategoryInitController();
        $cat->categories_init();

        $voucher = new VoucherInitController();
        $voucher->voucher_init();

        return $this->response;
    }


}
