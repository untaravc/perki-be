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
                "user_is_speaker"            => 0,
                "user_name"                  => 'Untara',
                "user_email"                 => "vyvy1777@gmail.com",
                "user_email_verified_at"     => now(),
                "user_password"              => Hash::make('password'),
                "user_phone"                 => '081239709445',
                "user_institution"           => "UGM",
                "user_city"                  => 'Sleman',
                "user_province"              => "DIY",
                "user_job_type"              => null,
                "user_image"                 => null,
                "user_desc"                  => 'Oke',
                "user_forgot_password_token" => null,
                "user_type"                  => 'admin',
                "user_otp"                   => null,
                "user_status"                => 100,
                "remember_token"             => null,
            ],
            [
                "user_is_speaker"            => 0,
                "user_name"                  => 'Vivi',
                "user_email"                 => "untaravivichahya@gmail.com",
                "user_email_verified_at"     => now(),
                "user_password"              => Hash::make('password'),
                "user_phone"                 => '081239709445',
                "user_institution"           => "Tries",
                "user_city"                  => 'Kulon Progo',
                "user_province"              => "DIY",
                "user_job_type"              => null,
                "user_image"                 => null,
                "user_desc"                  => 'My Name is Khan',
                "user_forgot_password_token" => null,
                "user_type"                  => 'user',
                "user_otp"                   => null,
                "user_status"                => 100,
                "remember_token"             => null,
            ],
        ];

        foreach ($data as $item) {
            $user = User::whereUserEmail($item['user_email'])->first();
            if($user){
                $user->update($item);
            } else{
                User::create($item);
            }
        }
    }
}
