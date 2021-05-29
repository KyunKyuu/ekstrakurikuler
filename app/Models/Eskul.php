<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Eskul extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $table = 'eskul';
    protected $guarded = ['id','created_at','updated_at'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s'
    ];

    public function members()
    {
        return $this->hasMany(Member::class, 'id');
    }

    public function mentors()
    {
        return $this->hasMany(Mentor::class, 'id');
    }

    public function articles()
    {
        return $this->hasMany(Blog::class, 'id');
    }

    public function video()
    {
        return $this->hasMany(VideoEskul::class, 'id');
    }

     public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by')->withTrashed();
    }

    public function image()
    {
        return !$this->image ? asset('no-image.jpg') : asset("storage/" . $this->image);
    }

    
}
