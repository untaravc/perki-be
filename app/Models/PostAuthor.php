<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostAuthor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "post_id",
        "status",
        "title",
        "first_name",
        "surname",
        "email",
        "type",
        "institution",
        "order",
        "is_presenter",
        "is_corresponding",
    ];

    protected $casts = [
        'is_presenter' => 'boolean',
        'is_corresponding' => 'boolean',
    ];
}
