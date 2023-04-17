<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserInitController extends Controller
{
    public function user_init()
    {
        $data = [
            [
                "is_speaker"            => 0,
                "name"                  => 'Untara',
                "email"                 => "vyvy1777@gmail.com",
                "email_verified_at"     => now(),
                "password"              => Hash::make('password'),
                "phone"                 => '081239709445',
                "institution"           => "UGM",
                "city"                  => 'Sleman',
                "province"              => "DIY",
                "job_type_code"         => "NURS",
                "image"                 => null,
                "desc"                  => 'Oke',
                "forgot_password_token" => null,
                "type"                  => 'admin',
                "otp"                   => null,
                "status"                => 100,
            ],
            [
                "is_speaker"            => 0,
                "name"                  => 'Vivi',
                "email"                 => "untaravivichahya@gmail.com",
                "email_verified_at"     => now(),
                "password"              => Hash::make('password'),
                "phone"                 => '081239709445',
                "institution"           => "Tries",
                "city"                  => 'Kulon Progo',
                "province"              => "DIY",
                "job_type_code"         => "DRSP",
                "image"                 => null,
                "desc"                  => 'My Name is Khan',
                "forgot_password_token" => null,
                "type"                  => 'user',
                "otp"                   => null,
                "status"                => 100,
            ],
        ];

        foreach ($data as $item) {
            $user = User::whereEmail($item['email'])->first();
            if ($user) {
                $user->update($item);
            } else {
                User::create($item);
            }
        }
    }
}
