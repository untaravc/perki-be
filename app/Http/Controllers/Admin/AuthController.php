<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        $this->response['status'] = false;

        $message = 'Email atau password salah.';
        $validator = Validator::make($request->all(), [
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            $this->response['message'] = $message . '01';
            return $this->response;
        }

        $user = User::whereUserEmail($request->email)
            ->where('user_type', 'admin')
            ->whereUserStatus(1)
            ->first();

        if (!$user) {
            $this->response['message'] = $message . '02';
            return $this->response;
        }

        if (!Hash::check($request->password, $user->user_password)) {

            $this->response['message'] = $message . '03';
            return $this->response;
        }

        $token = $user->createToken('admin');

        $user->update([
            'last_login' => now(),
        ]);

        $this->response['status'] = true;
        $this->response['result'] = [
            'token' => $token->plainTextToken,
            'user'  => $user
        ];

        return $this->response;
    }

    public function profile(Request $request)
    {
        $data = $request->user()->only(['user_id', 'user_name', 'user_email']);
        return $this->sendGetResponse($data, '');
    }

    public function adminPanel(){
        return view('admin.Layout');
    }

    public function notFound()
    {
        return view('404');
    }
}
