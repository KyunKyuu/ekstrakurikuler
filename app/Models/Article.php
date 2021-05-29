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
    protected $fillable = ['user_id', 'eskul_id','title', 'content', 'image', 'slug', 'deleted_at','thumbnail','status'];
    protected $dates = ['deleted_at'];

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withPivot('category_id', 'blog_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function eskul()
    {
        return $this->belongsTo(Eskul::class, 'eskul_id');
    }

    public function thumbnail()
    {
        return !$this->thumbnail ? asset('no-image.jpg') : asset("storage/" . $this->thumbnail);
    }
}
