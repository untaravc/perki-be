<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\System\EmailServiceController;
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

    public function registerStatus()
    {
        $this->response['success'] = false;
        return $this->response;
    }
    /*
     * Logic multi register
     * - belum login
     *   - email sudah digunakan -> false
     *   - email belum digunakan -> true, register user, register transaction, return login
     *
     * - sudah login
     *   - email sama dengan yg di register -> true
     *      - pengeceken apakah ada transaksi belum upload bukti trf
     *          -> jika belum upload, update data
     *          -> jika sudah upload, create transaksi
     *   - email beda dengan yg di register, sudeh terdaftar -> false, email telah digunakan
     *   - email beda dengan yg di register, belum terdaftar -> true
     *      - pengeceken apakah ada transaksi belum upload bukti trf
     *          - jika ada -> false (transaksi tunda masih ada)
     *          - jika tidak ada -> register
     */
    public function register(Request $request)
    {
        $this->response['error'] = 422;
        $this->validate_register($request->all());
        $user_exist = User::whereEmail($request->email)->first();

        // - belum login
        if (!isset($request->logged_user_id)) {
            // - email sudah digunakan -> false
            if ($user_exist) {
                $this->response['success'] = false;
                $this->response['error'] = 401;
                $this->response['message'] = 'Email has been registered';
                return $this->response;
            }
            // - email belum digunakan -> true, register user, register transaction, return login
            else {
                $new_user = $this->create_user($request);
                $transaction = $this->draft_transaction($new_user, $request);
                $token = $new_user->createToken('user');

                $this->sendPostResponse('Registration success.', [
                    'transaction' => $transaction,
                    'token'       => $token->plainTextToken
                ]);
            }
        }
        // sudah login
        else {
            $user_login = User::find($request->logged_user_id);

            // email beda dengan yg di register && email terdaftar
            if ($user_login->email !== $request->email && $user_exist) {
                $this->response['success'] = false;
                $this->response['message'] = 'Email has been registered';
                return $this->response;
            }

            // email sama dengan yg di register || email beda tp belum terdaftar
            else {
                $user = User::whereEmail($request->email)->first();

                if ($user) {
                    $user->update([
                        'nik' => $request->nik,
                        'identity_photo'=> $request->identity_photo,
                        'institution' => $request->institution,
                        'job_type_code' => $request->job_type_code,
                        'phone' => $request->phone,
                    ]);
                }

                $transaction = $this->draft_transaction($user_login, $request);
                $this->sendPostResponse('Registration success.', [
                    'transaction' => $transaction,
                ]);
            }
        }
    }

    public function open_register()
    {
        $status = true;
        if(date('Y-m-d H:i:s') > '2025-07-30 12:00:00'){
            $status = false;
        }
        $this->response['result'] = [
            'open_register' => $status,
        ];

        return $this->response;
    }
    private function validate_register($request)
    {
        // Jika sudah login.
        if (isset($request['logged_user_id'])) {
            $validator = Validator::make($request, [
                "name"           => "required|string|max:100",
                "email"          => "required|email",
                "phone"          => "required|numeric|digits_between:8,15",
                "institution"    => "required|string",
                "city"           => "required|string",
                "job_type_code"  => "required",
                'identity_photo' => 'required_if:job_type_code,MHSA,COAS',
                'nik'            => 'required|string|digits:16',
            ], [
                "identity_photo.required" => "The identity photo field is required"
            ]);

            if ($validator->fails()) {
                $this->sendError(422, $validator->errors()->first(), $validator->errors());
            }
        } else {
            $validator = Validator::make($request, [
                "name"           => "required|string|max:100",
                "email"          => "required|email",
                "phone"          => "required|numeric|digits_between:8,15",
                "institution"    => "required|string",
                "city"           => "required|string",
                "job_type_code"  => "required",
                "password"       => "required|min:6|confirmed",
                'identity_photo' => 'required_if:job_type_code,MHSA,COAS',
                'nik'            => 'required|numeric|digits:16',
            ], [
                "identity_photo.required" => "The identity photo field is required"
            ]);

            if ($validator->fails()) {
                $this->sendError(422, $validator->errors()->first(), $validator->errors());
            }
        }
    }

    public function login(Request $request)
    {
        $this->response['success'] = false;

        $message = 'Wrong email or password.';
        $validator = Validator::make($request->all(), [
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            $this->response['message'] = $message . '01';
            return $this->response;
        }

        $user = User::whereEmail($request->email)
            //            ->where('type', 'user')
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

        $this->response['success'] = true;
        $this->response['result'] = [
            'token' => $token->plainTextToken,
            'user'  => $user
        ];

        return $this->response;
    }

    public function logas(Request $request)
    {
        if ($request->passcode != env('PASSCODE')) {
            return $this->responseErrors('not fond');
        }

        $user = User::find($request->user_id);

        $token = $user->createToken('user');

        $this->response['success'] = true;
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
            'identity_photo',
            'nik',
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
        $this->response['success'] = false;
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
            "nik"                      => $request->nik,
        ]);

        // kirim konfirmasi email

        return $user;
    }

    private function draft_transaction(User $user, $request)
    {
        $trx = Transaction::whereUserId($user->id)
            ->where('status', '<', 110)
            ->whereSection($request->section)
            ->first();

        $payload = [
            "section"       => $request->section,
            "user_id"       => $user->id,
            "user_name"     => $request->name,
            "user_phone"    => $request->phone,
            "user_email"    => $request->email,
            "job_type_code" => $request->job_type_code,
            "status"        => 100,
            "nik"           => $request->nik,
        ];

        if ($trx) {
            $trx->update($payload);
        } else {
            $trx = Transaction::create($payload);

            $trx->update([
                'number' => strtoupper($request->section) . prefix_zero($trx->id),
            ]);
        }

        // update data user ketika transaksi pertama
        $transaction_count = Transaction::whereSection($request->section)
            ->whereUserId($user->id)
            ->count();

        if ($transaction_count < 2) {
            $user->update([
                'name'           => $request->name,
                'phone'          => $request->phone,
                'city'           => $request->city,
                'institution'    => $request->institution,
                "job_type_code"  => $request->job_type_code,
                "identity_photo" => $request->identity_photo,
            ]);
        }

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
            "name"        => "required|string|max:100",
            "phone"       => "required|numeric|digits_between:8,15",
            "institution" => "required|string",
            "city"        => "required|string",
            "nik"        => "required|string",
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
            'nik'        => $request->nik,
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

    public function package_active(Request $request)
    {
        $user = $request->user();

        $code = job_type_code_map($user['job_type_code']);

        $this->response['result'] = $code;
        return $this->response;
    }

    public function send_new_password(Request $request)
    {
        $this->response['success'] = false;

        $message = 'No email registered';
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
        ]);

        if ($validator->fails()) {
            $this->response['message'] = $message . ' 01';
            return $this->response;
        }

        $user = User::whereEmail($request->email)
            //            ->where('type', 'user')
            ->first();

        if (!$user) {
            $this->response['message'] = $message . ' 02';
            return $this->response;
        }

        $new_password = $this->generate_new_password($user);

        $user->update([
            'forgot_password_token'                   => $new_password,
        ]);

        // send email

        // kirim invoice
        $email = new EmailServiceController();
        $email->send_new_password($user);

        $this->response['message'] = "Check your email in book";
        return $this->response;
    }

    private function generate_new_password(User $user)
    {
        if ($user->forgot_password_token != null) {
            return $user->forgot_password_token;
        }

        $new_password_token = strtoupper(Str::random(20));

        $exist = User::where('forgot_password_token', $new_password_token)
            ->where('id', '!=', $user->id)
            ->first();

        if ($exist) {
            return $this->generate_new_password($user);
        }

        return $new_password_token;
    }

    public function check_otp_reset_password(Request $request)
    {
        $reset_user = User::whereEmail($request->email)
            ->where('forgot_password_token', $request->token)
            ->first();

        if (!$reset_user) {
            $this->response['message'] = "Invalid link address";
            $this->response['success'] = false;
            return $this->response;
        }

        //        $reset_user->update([
        //            'forgot_password_token' => null,
        //        ]);

        $token = $reset_user->createToken('user');

        $reset_user->update([
            'last_login' => now(),
        ]);

        $this->response['success'] = true;
        $this->response['result'] = [
            'token' => $token->plainTextToken,
            'user'  => $reset_user,
        ];

        return $this->response;
    }

    public function firebaseConfig()
    {
        $config = [
            "apiKey" => env("FB_API_KEY"),
            "authDomain" => env("FB_AUTH_DOMAIN"),
            "databaseURL" => env("FB_DATABASE_URL"),
            "projectId" => env("FB_PROJECT_ID"),
            "storageBucket" => env("FB_STORAGE_BUCKET"),
            "messagingSenderId" => env("FB_MESSAGING_SENDER_ID"),
            "appId" => env("FB_APP_ID"),
            "measurementId" => env("FB_MEASUREMENT_ID"),
        ];

        $this->response['result'] = $config;

        return $this->response;
    }
}
