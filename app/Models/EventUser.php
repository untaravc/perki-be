<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 100 -> new scaned
 * 200 -> print
 */
class EventUser extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function scanner(){
        return $this->belongsTo(User::class, 'scanner_id', 'id');
    }

    public function event(){
        return $this->belongsTo(Event::class);
    }
}
