<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/*
 * Status
 * 100 -> pending, belum ada transaksi
 * 110 -> sudah memilih event
 * 120 -> sudah upload transfer proof
 * 200 -> sudah bayar
 * 300 -> Sub Transaction
 * 400 -> deleted
 */

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $appends = ['last_time', 'status_label','user_phone_wa'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function users(){
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function transaction_details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function getLastTimeAttribute()
    {
        if(isset($this->attributes['updated_at'])){
            return date('Y-m-d H:i:s', strtotime($this->attributes['updated_at'] . '+24 hours'));
        }
    }

    public function getUserPhoneWaAttribute()
    {
        if(isset($this->attributes['user_phone']) && $this->attributes['user_phone']){
            $number = $this->attributes['user_phone'][0];
            if($number === '0'){
                return "62" . substr($this->attributes['user_phone'], 1);
            }
        }
    }

    public function getStatusLabelAttribute()
    {
        if (isset($this->attributes['status'])) {
            switch ($this->attributes['status']) {
                case 100: return 'Select Event';
                case 110: return 'Waiting payment';
                case 120: return 'Waiting confirmation';
                case 200: return 'Paid';
                case 300: return 'Sub Transaction';
                case 400: return 'Deleted';
            }
        }
    }

    public function getJobTypeCodeLabelAttribute()
    {
        if (isset($this->attributes['job_type_code'])) {
            switch ($this->attributes['job_type_code']) {
                case 'MHSA': return 'Medical student';
                case 'COAS': return 'Co-ass';
                case 'NURS': return 'Nurse';
                case 'ITRS': return 'Internship';
                case 'RSDN': return 'Residency';
                case 'DRGN': return 'General Practitioner';
                case 'DRSP': return 'Specialist';
                case 'OTHR': return 'Healthcare Provider';
                default: return $this->attributes['job_type_code'];
            }
        }
    }
}
