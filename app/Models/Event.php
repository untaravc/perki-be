<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        "event_name",
        "event_parent_id",
        "event_date_start",
        "event_date_end",
        "event_has_price",
    ];
}
