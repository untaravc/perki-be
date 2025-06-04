<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

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
        if ($request->name) {
            $data_content = $data_content->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->type) {
            $data_content = $data_content->where('type', $request->type);
        }

        return $data_content;
    }

    public function show($id)
    {
        $data = User::find($id);

        $this->response['result'] = $data;
        return $this->response;
    }

    public function update(Request $request, $id)
    {
        $request->merge(['id' => $id]);
        $this->validateData($request);

        $data = User::find($request->id);
        if ($data) {
            if ($request->password) {
                $request->merge([
                    'password' => Hash::make($request->password)
                ]);
            }
            $data->update($request->all());
            $this->response['message'] = 'Updated!';
        } else {
            $this->response['success'] = false;
            $this->response['message'] = 'Not Found';
        }

        return $this->response;
    }

    public function validateData($request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
        ]);

        if ($validator->fails()) {
            $this->response['errors'] = $validator->errors();
            abort(response($this->response, 422));
        }
    }

    public function registerUser(Request $request)
    {
        $access_token = PersonalAccessToken::findToken($request->token);
        if(!$access_token){
            return 'No Access';
        }

        $users = User::whereIsSpeaker(0)
            ->with('success_transactions')
            ->get();

        return view('print.contacts.register-user', compact('users'));
    }
}
