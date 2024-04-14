<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index(Request $request){
        $data_content = Voucher::orderByDesc('id')->withCount('redeem');
        $data_content = $this->withFilter($data_content, $request);
        $data_content = $data_content->paginate($request->per_page ?? 25);

        $collect = collect($this->response);
        return $collect->merge($data_content);
    }

    private function withFilter($data_content, Request $request){
        if($request->name){
            $data_content = $data_content->where(function($q) use ($request){
                $q->where('name', 'like','%' . $request->name . '%')
                    ->orWhere('code', 'like','%' . $request->name . '%');
            });
        }

        if($request->type){
            $data_content = $data_content->where('type', $request->type);
        }
        
        if($request->year){
            $data_content = $data_content->whereYear('created_at', $request->year);
        }

        return $data_content;
    }
}
