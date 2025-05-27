<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Transaction;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(){
        $data = Section::orderBy('section')
            ->whereStatus(1)
            ->get();

        $this->response['result'] = $data;
        return $this->response;
    }
}
