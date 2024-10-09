<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $appends = ['status_label', 'body_parsed', 'abstract_number', 'image_link'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
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

    public function getImageLinkAttribute()
    {
        if (isset($this->attributes['image']) && $this->attributes['image'] != null) {
            return $this->attributes['image'];
        } else {
            return env('APP_URL') . 'assets24/logo/empty-image.png';
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
                case 'meta_analysis':
                    return 'MA0' . $this->attributes['id'];
                default:
                    return null;
            }
        }
    }
}
