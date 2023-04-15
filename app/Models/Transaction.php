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
}
