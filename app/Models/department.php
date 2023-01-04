<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class department extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'department_name',
    ];

    // Connect Table by Eloquent method
    public function user() {
        return $this->hasOne(user::class,'id','user_id');
    }
}

