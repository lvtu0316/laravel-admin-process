<?php

namespace App\Models;

use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Event extends Model
{
    protected $table = "events";
    protected $fillable = ['event_tile','event_content','solution','ip','user_id','category_id',
        'client_id','alarm_time','degree','operate_user_id','operate_user_role_id'];

    const FUWUTAI = 0;
    const YIXIAN = 1;
    const ERXIAN = 2 ;
    const SUCCESS = 3;

    public function category()
    {
        return $this->belongsTo(EventCategory::class,'category_id','id');
    }
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
    public function statuss()
    {
        return $this->belongsTo(Status::class,'operate_user_role_id','role_id');
    }

    public function degrees()
    {
        return $this->belongsTo(Degree::class,'degree','id');
    }

    public function get_status($key)
    {
        switch ($key)
        {
            case 'fuwutai':
                return self::FUWUTAI;
            case 'yixian':
                return self::YIXIAN;
            case 'success':
                return self::SUCCESS;
        }
    }
}
