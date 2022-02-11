<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repost extends Model
{
    use HasFactory;
    public $fillable = [
        'reposted',
        'user_id',
        'post_id'
    ];
}
