<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 100 Register
 * 200 Elimination
 * 300 Pass Elimination
 * 401 Winner 1
 * 402 Winner 2
 * 403 Winner 3
 */
class Group extends Model
{
    use HasFactory;
    protected $guarded = [];
}
