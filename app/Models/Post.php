<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $appends = ['status_label', 'body_parsed', 'abstract_number'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function authors()
    {
        return $this->hasMany(PostAuthor::class);
    }

    public function getStatusLabelAttribute()
    {
        if (isset($this->attributes['status'])) {
            switch ($this->attributes['status']) {
                case 1:
                    return 'publish';
                default:
                    return 'pending';
            }
        }
    }

    public function getBodyParsedAttribute()
    {
        if (isset($this->attributes['body'])) {
            return json_decode($this->attributes['body'], true);
        }
    }

    public function getAbstractNumberAttribute()
    {
        if (isset($this->attributes['category']) && isset($this->attributes['id'])) {
            switch ($this->attributes['category']) {
                case 'research':
                    return 'RS0' . $this->attributes['id'];
                case 'systematic_review':
                    return 'SR0' . $this->attributes['id'];
                case 'case_report':
                    return 'CR0' . $this->attributes['id'];
                default:
                    return null;
            }
        }
    }
}
