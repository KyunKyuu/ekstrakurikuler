<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Alumni extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'alumnies';
    protected $guarded = ['id','created_at','updated_at'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s'
    ];

    // public function member()
    // {
    //     return $this->belongsTo(Member::class, 'member_id')->withTrashed();
    // }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by')->withTrashed();
    }

     public function image()
    {
        return !$this->image ? asset('no-image.jpg') : asset("storage/" . $this->image);
    }
}
