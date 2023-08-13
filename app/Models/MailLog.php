<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailLog extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['status_label'];

    public function getStatusLabelAttribute(){
        if(isset($this->attributes['status'])){
            switch ($this->attributes['status']){
                case 0: return "pending";
                case 1: return "sent";
                case 2: return "failed";
            }
        }
    }
}
