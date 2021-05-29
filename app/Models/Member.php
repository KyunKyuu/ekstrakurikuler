<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'members';
    protected $guarded = ['id','created_at','updated_at'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
        'entry_year' => 'date:Y-m-d'
    ];

    public function division()
    {
        return $this->belongsTo(Eskul::class,'division_id')->withTrashed();
    }

    // public function alumni()
    // {
    //     return $this->hasOne(Alumni::class, 'id');
    // }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by')->withTrashed();
    }

     public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

     public function image()
    {
        return !$this->image ? asset('no-image.jpg') : asset("storage/" . $this->image);
    }

}
