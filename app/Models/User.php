<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Status
 * 100 -> pending, data belum lengkap
 * 200 -> register event, data lengkap
 * 400 -> block
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        "is_speaker",
        "name",
        "email",
        "email_verified_at",
        "password",
        "phone",
        "institution",
        "city",
        "province",
        "job_type_code",
        "type", // user, admin, committee
        "image",
        "desc",
        "forgot_password_token",
        "otp",
        "status",
        "remember_token",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
