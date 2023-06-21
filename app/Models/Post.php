<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $appends =['status_label', 'body_parsed'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function authors(){
        return $this->hasMany(PostAuthor::class);
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

    public function getBodyParsedAttribute(){
        if(isset($this->attributes['body'])) {
            return json_decode($this->attributes['body'], true);
        }
    }
}
