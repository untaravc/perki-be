<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DataInitController extends Controller
{
    public function init()
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
                "user_status"                => 1,
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
                "user_status"                => 1,
                "remember_token"             => null,
            ],
        ];

        foreach ($data as $item) {
            User::create($item);
        }
    }
}
