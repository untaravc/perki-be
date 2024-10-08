<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "code",
        "role",
        "type",
        "value",
        "qty",
        "qty_rest",
        "status",
    ];

    public function redeem(){
        return $this->hasMany(Transaction::class, 'voucher_code', 'code')->whereStatus(200);
    }
}
