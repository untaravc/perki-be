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
                "name"                  => 'Vyvy 1777',
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
                "name"                  => 'Review',
                "email"                 => "reviewer@perki-jogja.com",
                "password"              => Hash::make('password'),
                "type"                  => 'reviewer',
                "status"                => 100,
            ],
            [
                "name"                  => 'Room 1',
                "email"                 => "room1@perki-jogja.com",
                "type"                  => 'room',
            ],
            [
                "name"                  => 'Room 2',
                "email"                 => "room2@perki-jogja.com",
                "type"                  => 'room',
            ],
            [
                "name"                  => 'Room 3',
                "email"                 => "room3@perki-jogja.com",
                "type"                  => 'room',
            ],
            [
                "name"                  => 'Room 4',
                "email"                 => "room4@perki-jogja.com",
                "type"                  => 'room',
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
