<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 100 -> new scaned
 * 200 -> print
 */
class EventUser extends Model
{
    use HasFactory;
    protected $appends = ['status_label'];
    protected $guarded = [];

    public function scanner(){
        return $this->belongsTo(User::class, 'scanner_id', 'id');
    }

    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function getStatusLabelAttribute()
    {
        if (isset($this->attributes['status'])) {
            switch ($this->attributes['status']) {
                case 100: return 'New';
                case 200: return 'Recorded';
            }
        }
    }
}
