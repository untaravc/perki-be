<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventPrice extends Model
{
    use HasFactory;
    protected $fillable = [
        "event_id",
        "job_type_code",
        "price",
    ];
}
