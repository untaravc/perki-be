<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test_view(){
        return view();
    }

    public function sample_qrcode(Request $request){
        return view('email.jcu22.qr_code', compact('qr_link'));
    }
}
