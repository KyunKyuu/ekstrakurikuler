<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes;
    use SoftDeletes;

    protected $table = 'blogs';
    protected $fillable = ['user_id', 'title', 'content', 'image', 'slug', 'deleted_at','thumbnail','status'];
    protected $dates = ['deleted_at'];

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
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
