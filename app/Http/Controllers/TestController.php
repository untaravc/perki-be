<?php

namespace App\Http\Controllers;

use App\Http\Controllers\System\EmailServiceController;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test_view(){
        $ctrl = new EmailServiceController();
        return $ctrl->qr_code_access(124);
    }

    public function sample_qrcode(Request $request){}
}
