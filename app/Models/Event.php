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
}
