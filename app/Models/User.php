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

    protected $appends = ['job_label'];

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
        "slug",
        "identity_photo",
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJobLabelAttribute()
    {
        if (isset($this->attributes['job_type_code'])) {
            switch ($this->attributes['job_type_code']) {
                case 'DRSP':
                    return 'Dokter Spesialis';
                case 'DRGN':
                    return 'Dokter Umum';
                case 'NURS':
                    return 'Perawat';
            }
        }
    }

    public function success_transactions(){
        return $this->hasMany(Transaction::class)->where('status', '>', 199)
            ->where('status', '<', 299);
    }
}
