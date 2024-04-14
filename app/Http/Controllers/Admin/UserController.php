<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data_content = User::orderByDesc('id');
        $data_content = $this->withFilter($data_content, $request);
        $data_content = $data_content->paginate($request->per_page ?? 25);

        $collect = collect($this->response);
        return $collect->merge($data_content);
    }

    public function withFilter($data_content, $request)
    {
        if ($request->s) {
            $data_content = $data_content->where('name', 'LIKE', '%' . $request->s . '%');
        }

        return $data_content;
    }

    public function show($id)
    {
        $data = User::find($id);

        $this->response['result'] = $data;
        return $this->response;
    }
}
