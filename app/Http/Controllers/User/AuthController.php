<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public $dev_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6ImFjZGEzNjBmYjM2Y2QxNWZmODNhZjgzZTE3M2Y0N2ZmYzM2ZDExMWMiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJodHRwczovL2FjY291bnRzLmdvb2dsZS5jb20iLCJuYmYiOjE2ODEyNjMwNTEsImF1ZCI6IjkxNTU3MDQ3Nzc2Mi1uc3RsYW9kOXRxNWZiZnN1bmNodWkyMXVsZzlvZ3BoMC5hcHBzLmdvb2dsZXVzZXJjb250ZW50LmNvbSIsInN1YiI6IjEwNTgwMDg1NDc1NzIzOTM0NzQ5NCIsImVtYWlsIjoidnl2eTE3NzdAZ21haWwuY29tIiwiZW1haWxfdmVyaWZpZWQiOnRydWUsImF6cCI6IjkxNTU3MDQ3Nzc2Mi1uc3RsYW9kOXRxNWZiZnN1bmNodWkyMXVsZzlvZ3BoMC5hcHBzLmdvb2dsZXVzZXJjb250ZW50LmNvbSIsIm5hbWUiOiJVbnRhcmEgVml2aSBDaGFoeWEiLCJwaWN0dXJlIjoiaHR0cHM6Ly9saDMuZ29vZ2xldXNlcmNvbnRlbnQuY29tL2EvQUdObXl4WVotdzY4YVBxai16U2NuUkl4NUoySW9teS1YQmZxNHp3RWxNQkNFUT1zOTYtYyIsImdpdmVuX25hbWUiOiJVbnRhcmEiLCJmYW1pbHlfbmFtZSI6IlZpdmkgQ2hhaHlhIiwiaWF0IjoxNjgxMjYzMzUxLCJleHAiOjE2ODEyNjY5NTEsImp0aSI6ImYzNzFkZjhiNTFiNTYwMTgwMWE3ZTc5NzExOWExYjYxNzdjMDk0OTYifQ.edBxFuPcVVu8Rsne0AwsdcYMm5sir3Q-U8umWT21sBgjKjawtyVsy2Dluz_AkWytaTLJcIXBVt3a5ZeXotU4hBT_RVP2FNrJQn6-vLIh44d354nSrBv4sXUpzVziGuO9pmE3-uEJDlAtWDcE-T34y8qRQ5v3mza0lQPp0vMI5bMhiU87YEfftQtqTVU7uLetMvKhNYb7DygMeCPlCN4fG8l9wwU-JC9RKXVR2Q7LqSxHGUD71MsrYByiJV7-4WxXLzbefF1OOgfhAqi0nUySOUiUuYcg4arbIr7737fX8GFGlXF4dGiAb8tygle4IHMxdk9t6qwiBfK7dfjVK1gAyA";

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

        $user = User::whereEmail($request->email)
            ->where('type', 'user')
            ->whereStatus(1)
            ->first();

        if (!$user) {
            $this->response['message'] = $message . '02';
            return $this->response;
        }

        if (!Hash::check($request->password, $user->password)) {
            $this->response['message'] = $message . '03';
            return $this->response;
        }

        $token = $user->createToken('user');

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
        return $this->sendResponse(200, $data);
    }

    public function login_by_google(Request $request)
    {
        $url_google = "https://oauth2.googleapis.com/tokeninfo?id_token=";
        $id_token = $request->id_token ?? $this->dev_token;

        if (!$id_token) {
            $this->sendError(422);
        }

        $client = new Client();
        $response = $client->request('GET', $url_google . $id_token);

        $json = json_decode($response->getBody(), true);

        $data['name'] = $json['name'];
        $data['email'] = $json['email'];
        $data['image'] = $json['picture'];

        // jika email ada, maka login
        $user = User::whereEmail($data['email'])->first();
        if ($user) {
            $token = $user->createToken('user');
            $result = [
                'token' => $token->plainTextToken,
                'user'  => $user
            ];

            $this->sendPostResponse('Success', $result);
        }

        // jika belum ada maka register
        $user = User::create([
            "name"              => $data['name'],
            "email"             => $data['email'],
            "email_verified_at" => now(),
            "image"             => $data['image'],
            "type"              => "user",
            "last_login"        => now(),
            "status"            => 100,
        ]);

        $token = $user->createToken('user');
        $result = [
            'token' => $token->plainTextToken,
            'user'  => $user
        ];

        $this->sendPostResponse('Success', $result);
    }
}
