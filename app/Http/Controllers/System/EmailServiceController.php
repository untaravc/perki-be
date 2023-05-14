<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailServiceController extends Controller
{
    public function register(){
        $data = [
            'name' => '',
            'link' => '',
        ];
        return view('email.jcu22.email-confirmation', $data);
    }

    public function bill(){
        $data = [
            'name' => 'Budi',
            'link' => '',
        ];
        return view('email.jcu22.bill', $data);
    }

    public function invoice(){
        $data = [
            'name' => 'Budi',
            'link' => '',
        ];
        return view('email.jcu22.invoice', $data);
    }
}
