<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MailLog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MailLogController extends Controller
{
    public function index(Request $request){
        $data_content = MailLog::orderByDesc('id');
        $data_content = $this->withFilter($data_content, $request);
        $data_content = $data_content->paginate($request->per_page ?? 25);

        $collect = collect($this->response);
        return $collect->merge($data_content);
    }

    private function withFilter(Builder $data_content, Request $request){
        if($request->status !== null){
            $data_content = $data_content->where('status', $request->status);
        }

        if($request->label){
            $data_content = $data_content->where('label', 'like','%' . $request->label . '%');
        }

        if($request->name){
            $data_content = $data_content->where(function($q) use ($request){
                $q->where('receiver_name', 'like','%' . $request->name . '%')
                    ->orWhere('email_receiver', 'like','%' . $request->name . '%');
            });
        }

        return $data_content;
    }
}
