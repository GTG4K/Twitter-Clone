<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    public $fillable = [
        'author',
        'comment',
        'likes',
        'user_id',
        'post_id'
    ];
}
