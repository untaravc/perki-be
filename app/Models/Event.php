<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "name",
        "section",
        "marker",
        "slug",
        "data_type",
        "parent_id",
        "date_start",
        "date_end",
        "has_price",
        "title",
        "image",
        "place",
        "speaker_ids",
        "speakers",
        "certificate",
        "status",
        "link",
        "subtitle",
        "body",
    ];

    public function speaker(){
        return $this->belongsTo(User::class, 'speakers','slug');
    }

    public function schedule_details(){
        return $this->hasMany(self::class, 'parent_id', 'id')
            ->where('data_type', 'schedule-detail');
    }

    public function schedules(){
        return $this->hasMany(self::class, 'parent_id', 'id')
            ->where('data_type', 'schedule')->with('speaker');
    }

    public function transaction_success(){
        $exclude_user_ids = exclude_user_ids();
        return $this->hasMany(TransactionDetail::class)
            ->whereNotIn('user_id', $exclude_user_ids)
            ->whereStatus(200);
    }

    public function transactions(){
        $exclude_user_ids = exclude_user_ids();
        return $this->hasMany(TransactionDetail::class)
            ->whereNotIn('user_id', $exclude_user_ids)
            ->where('status','<',400);
    }

    public function transaction_success_std(){
        $exclude_user_ids = exclude_user_ids();
        return $this->hasMany(TransactionDetail::class)
            ->whereStatus(200)
            ->whereNotIn('user_id', $exclude_user_ids)
            ->whereIn('job_type_code',['MHSA','COAS']);
    }

    public function transaction_success_gp(){
        $exclude_user_ids = exclude_user_ids();
        return $this->hasMany(TransactionDetail::class)
            ->whereStatus(200)
            ->whereNotIn('user_id', $exclude_user_ids)
            ->whereIn('job_type_code',['DRGN','ITRS','RSDN','NURS']);
    }

    public function transaction_success_sp(){
        $exclude_user_ids = exclude_user_ids();
        return $this->hasMany(TransactionDetail::class)
            ->whereStatus(200)
            ->whereNotIn('user_id', $exclude_user_ids)
            ->whereJobTypeCode('DRSP');
    }

    public function transaction_pending(){
        $exclude_user_ids = exclude_user_ids();
        return $this->hasMany(TransactionDetail::class)
            ->whereNotIn('user_id', $exclude_user_ids)
            ->where('status', '<', 200);
    }
}
