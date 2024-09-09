<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getPhoneAttribute($val)
    {
        if (strlen($val) > 8) {
            if (substr($val, 0, 1) == '0') {
                return '62' . substr($val, 1);
            } else if (substr($val, 0, 4) == '6262') {
                return '62' . substr($val, 4);
            } else if (substr($val, 0, 2) == '62') {
                return $val;
            } else if (substr($val, 0, 1) == '8') {
                return '62' . $val;
            }
        }
    }
}
