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
}
