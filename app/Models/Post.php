<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends =['status_label'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute(){
        if(isset($this->attributes['status'])){
            switch ($this->attributes['status']){
                case 1:
                    return 'publish';
                default: return 'pending';
            }
        }
    }
}
