<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'blogs';
    protected $fillable = ['user_id', 'title', 'content', 'image', 'slug', 'deleted_at'];
    protected $dates = ['deleted_at'];
}
