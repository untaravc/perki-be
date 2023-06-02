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
        "slug",
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

    public function schedule_details(){
        return $this->hasMany(self::class, 'parent_id', 'id')
            ->where('data_type', 'schedule-detail');
    }
}
