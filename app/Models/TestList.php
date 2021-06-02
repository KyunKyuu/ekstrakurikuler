<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestList extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'list_test';
    protected $fillable = ['division_id', 'name', 'deskripsi', 'value', 'created_by', 'deleted_at'];
     protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s'
    ];

    public function division()
    {
        return $this->hasOne(Eskul::class, 'id', 'division_id');
    }
}
