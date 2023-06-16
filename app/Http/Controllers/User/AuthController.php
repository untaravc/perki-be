<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Models\Transaction;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends BaseController
{
    public $dev_token = "eyJhbGciOiJSUzI1NiIsImtpZCI6ImFjZGEzNjBmYjM2Y2QxNWZmODNhZjgzZTE3M2Y0N2ZmYzM2ZDExMWMiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJodHRwczovL2FjY291bnRzLmdvb2dsZS5jb20iLCJuYmYiOjE2ODEyNjMwNTEsImF1ZCI6IjkxNTU3MDQ3Nzc2Mi1uc3RsYW9kOXRxNWZiZnN1bmNodWkyMXVsZzlvZ3BoMC5hcHBzLmdvb2dsZXVzZXJjb250ZW50LmNvbSIsInN1YiI6IjEwNTgwMDg1NDc1NzIzOTM0NzQ5NCIsImVtYWlsIjoidnl2eTE3NzdAZ21haWwuY29tIiwiZW1haWxfdmVyaWZpZWQiOnRydWUsImF6cCI6IjkxNTU3MDQ3Nzc2Mi1uc3RsYW9kOXRxNWZiZnN1bmNodWkyMXVsZzlvZ3BoMC5hcHBzLmdvb2dsZXVzZXJjb250ZW50LmNvbSIsIm5hbWUiOiJVbnRhcmEgVml2aSBDaGFoeWEiLCJwaWN0dXJlIjoiaHR0cHM6Ly9saDMuZ29vZ2xldXNlcmNvbnRlbnQuY29tL2EvQUdObXl4WVotdzY4YVBxai16U2NuUkl4NUoySW9teS1YQmZxNHp3RWxNQkNFUT1zOTYtYyIsImdpdmVuX25hbWUiOiJVbnRhcmEiLCJmYW1pbHlfbmFtZSI6IlZpdmkgQ2hhaHlhIiwiaWF0IjoxNjgxMjYzMzUxLCJleHAiOjE2ODEyNjY5NTEsImp0aSI6ImYzNzFkZjhiNTFiNTYwMTgwMWE3ZTc5NzExOWExYjYxNzdjMDk0OTYifQ.edBxFuPcVVu8Rsne0AwsdcYMm5sir3Q-U8umWT21sBgjKjawtyVsy2Dluz_AkWytaTLJcIXBVt3a5ZeXotU4hBT_RVP2FNrJQn6-vLIh44d354nSrBv4sXUpzVziGuO9pmE3-uEJDlAtWDcE-T34y8qRQ5v3mza0lQPp0vMI5bMhiU87YEfftQtqTVU7uLetMvKhNYb7DygMeCPlCN4fG8l9wwU-JC9RKXVR2Q7LqSxHGUD71MsrYByiJV7-4WxXLzbefF1OOgfhAqi0nUySOUiUuYcg4arbIr7737fX8GFGlXF4dGiAb8tygle4IHMxdk9t6qwiBfK7dfjVK1gAyA";

    // Register Event
    public function register(Request $request)
    {
        $this->validate_register($request->all());
        $user = User::whereEmail($request->email)->first();

        // jika email sudah ada, beda dengan logged_user_id, return false, silakan login
        if (isset($request->logged_user_id) && $user && $user->id != $request->logged_user_id) {
            $this->sendError(403);
        }

        // email sudah digunakan
        if ($user && $request->logged_user_id == null) {
            $this->sendError(422, 'Email telah digunakan.');
        }

        // jika email belum ada register
        if (!$user) {
            $user = $this->create_user($request);
        }

        // update data user
        $user->update([
            'name'          => $request->name,
            'phone'         => $request->phone,
            "job_type_code" => $request->job_type_code,
        ]);

        // jika sudah ada, langsung buat transaksi, status 100 (pending)
        $transaction = $this->draft_transaction($user, $request);

        $token = $user->createToken('user');
        // return data transaksi
        $this->sendPostResponse('Pendaftaran berhasil', [
            'transaction' => $transaction,
            'token'       => $token->plainTextToken
        ]);
    }

    private function validate_register($request)
    {
        // Jika sudah login.
        if (isset($request['logged_user_id'])) {
            $validator = Validator::make($request, [
                "name"          => "required|string|max:100|regex:/^[\pL\s\-]+$/u",
                "email"         => "required|email",
                "phone"         => "required|numeric|digits_between:8,15",
                "institution"   => "required|string",
                "city"          => "required|string",
                "job_type_code" => "required",
            ]);

            if ($validator->fails()) {
                $this->sendError(422, $validator->errors()->first(), $validator->errors());
            }
        } else {
            $validator = Validator::make($request, [
                "name"          => "required|string|max:100|regex:/^[\pL\s\-]+$/u",
                "email"         => "required|email|unique:users",
                "phone"         => "required|numeric|digits_between:8,15",
                "institution"   => "required|string",
                "city"          => "required|string",
                "job_type_code" => "required",
                "password"      => "required|min:6|confirmed",
            ]);

            if ($validator->fails()) {
                $this->sendError(422, $validator->errors()->first(), $validator->errors());
            }
        }
    }

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
//            ->whereStatus(1)
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
        $data = User::select([
            'id',
            'name',
            'email',
            'image',
            'phone',
            'institution',
            'city',
            'job_type_code',
        ])
            ->find($request->user()['id']);

        $this->sendGetResponse($data);
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

            $update_payload['last_login'] = now();
            if ($user->email_verified_at == null) {
                $update_payload['email_verified_at'] = now();
            }

            if ($user->image == null) {
                $update_payload['image'] = $data['image'];
            }

            $user->update($update_payload);

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

    public function check_token(Request $request)
    {
        if ($request->logged_user_id) {
            return $this->response;
        }
        $this->response['status'] = false;
        return $this->response;
    }

    private function create_user(Request $request)
    {
        $user = User::create([
            "is_speaker"               => 0,
            "name"                     => $request->name,
            "email"                    => $request->email,
            "email_verified_at"        => null,
            "password"                 => Hash::make($request->password),
            "phone"                    => $request->phone,
            "institution"              => $request->institution,
            "city"                     => $request->city,
            "province"                 => null,
            "job_type_code"            => $request->job_type_code,
            "type"                     => "user",
            "last_login"               => now(),
            "status"                   => 100,
            "email_verification_token" => Str::random(60),
        ]);

        // kirim konfirmasi email

        return $user;
    }

    private function draft_transaction($user, $request)
    {
        $trx = Transaction::whereUserId($user->id)
            ->whereStatus(100)
            ->first();

        if ($trx) {
            return $trx;
        }

        $payload = [
            "section"       => "jcu23",
            "number"        => null,
            "user_id"       => $user->id,
            "user_name"     => $request->name,
            "user_phone"    => $request->phone,
            "user_email"    => $request->email,
            "job_type_code" => $request->job_type_code,
            "status"        => 100,
        ];

        $trx = Transaction::create($payload);

        $trx->update([
            'number' => 'JCU23' . prefix_zero($trx->id),
        ]);

        return $trx;
    }

    public function logout(Request $request)
    {
        if ($request->all_device == 1) {
            $request->user()->tokens()->delete();
        } else {
            $request->user()->currentAccessToken()->delete();
        }

        $this->response['message'] = 'Logged out!';
        return $this->response;
    }

    public function profile_update(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            "name"        => "required|string|max:100|regex:/^[\pL\s\-]+$/u",
            "phone"       => "required|numeric|digits_between:8,15",
            "institution" => "required|string",
            "city"        => "required|string",
            "password"    => "nullable|min:6|confirmed",
        ]);

        if ($validator->fails()) {
            $this->sendError(422, $validator->errors()->first(), $validator->errors());
        }

        $model = User::find($user['id']);

        $model->update([
            'name'        => $request->name,
            'phone'       => $request->phone,
            'city'        => $request->city,
            'institution' => $request->institution,
        ]);

        if ($request->password) {
            $model->update([
                'password' => Hash::make($request->password),
            ]);
        }

        $this->response['message'] = "Profile updated";
        return $this->response;
    }

    public function profile_photo_update(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            "image" => "required|string",
        ]);

        if ($validator->fails()) {
            $this->sendError(422, $validator->errors()->first(), $validator->errors());
        }

        $model = User::find($user['id']);

        $model->update([
            'image' => $request->image,
        ]);

        return $this->response;
    }

    public function package_active(Request $request){
        $user = $request->user();

        $code = job_type_code_map($user['job_type_code']);

        $this->response['result'] = $code;
        return $this->response;
    }
}
