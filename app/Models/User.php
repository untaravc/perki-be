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

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function getJobLabelAttribute()
    {
        if (isset($this->attributes['job_type_code'])) {
            switch ($this->attributes['job_type_code']) {
                case 'DRSP':
                    return 'Dokter Spesialis';
                case 'DRGN':
                    return 'Dokter Umum';
                case 'NURS':
                    return 'Nurse';
                case 'ITRS':
                    return 'Internship';
                case 'RSDN':
                    return 'Resident';
                case 'COAS':
                    return 'Co-Ass';
                case 'MHSA':
                    return 'Medical Student';
                default:
                    return 'none';
            }
        } else {
            return 'None';
        }
    }

    public function getPhoneAttribute(){
        if(isset($this->attributes['phone'])){
            $phone = $this->attributes['phone'];
            if($phone[0] == 0){
                return '62' . substr($phone, 1);
            }
            return $phone;
        }
    }

    public function success_transactions()
    {
        $exclude_user_ids = exclude_user_ids();
        return $this->hasMany(Transaction::class)
            ->whereNotIn('user_id', $exclude_user_ids)
            ->where('status', '>', 199)
            ->where('status', '<', 299);
    }

    public function getImageAttribute()
    {
        if (env('APP_ENV') === 'local') {
            $img = $this->attributes['image'];
            return str_replace('https://src.perki-jogja.com/', 'http://127.0.0.1:8000/', $img);
        } else {
            return $this->attributes['image'];
        }
    }

    public function voucher_code()
    {
        return $this->hasOne(Voucher::class, 'name', 'name');
    }
}
