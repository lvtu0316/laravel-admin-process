<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    protected $fillable = ['title','category_id','user_id','status'];

    const STATUS_ON = 1;
    const STATUS_OFF = 0;

    public function category()
    {
        return $this->belongsTo(RepositoryCategory::class,'repository_category_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }


}
