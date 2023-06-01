<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*
 * Status
 * 100 -> pending, belum ada transaksi
 * 110 -> sudah memilih event
 * 120 -> sudah upload transfer proof
 * 200 -> sudah bayar
 */

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['last_time', 'status_label'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function transaction_details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function getLastTimeAttribute()
    {
        return date('Y-m-d H:i:s', strtotime($this->attributes['updated_at'] . '+24 hours'));
    }

    public function getStatusLabelAttribute()
    {
        if (isset($this->attributes['status'])) {
            switch ($this->attributes['status']) {
                case 100: return 'Select Event';
                case 110: return 'Waiting payment';
                case 120: return 'Waiting confirmation';
                case 200: return 'Paid';
            }
        }
    }
}
