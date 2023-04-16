<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*
 * Status
 * 100 -> pending, belum ada transaksi
 * 110 -> sudah memilih event
 * 200 -> sudah bayar
 */

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['last_time', 'status_label'];

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
                case 100: return 'tunda';
                case 110: return 'menunggu pembayaran';
                case 200: return 'lunas';
            }
        }
    }
}
