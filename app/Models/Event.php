<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

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

    public function schedule_details(){
        return $this->hasMany(self::class, 'parent_id', 'id')
            ->where('data_type', 'schedule-detail');
    }

    public function schedules(){
        return $this->hasMany(self::class, 'parent_id', 'id')
            ->where('data_type', 'schedule');
    }

    public function transaction_success(){
        return $this->hasMany(TransactionDetail::class)
//            ->whereStatus(200)
            ;
    }

    public function transaction_success_std(){
        return $this->hasMany(TransactionDetail::class)
//            ->whereStatus(200)
            ->whereJobTypeCode('MHSA');
    }

    public function transaction_success_gp(){
        return $this->hasMany(TransactionDetail::class)
//            ->whereStatus(200)
            ->whereJobTypeCode('DRGN');
    }

    public function transaction_success_sp(){
        return $this->hasMany(TransactionDetail::class)
//            ->whereStatus(200)
            ->whereJobTypeCode('DRSP');
    }
}
