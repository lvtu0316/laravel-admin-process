<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = "admin_roles";

    public function user()
    {
        return $this->belongsToMany(User::class,'admin_role_users','user_id','role_id');
    }

    public function status()
    {
        return $this->hasOne(Status::class,'role_id','id');
    }

}
