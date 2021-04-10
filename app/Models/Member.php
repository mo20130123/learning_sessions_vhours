<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    use Notifiable;
    // public $timestamps = false;
    protected $fillable = [
        'name', 'email', 'password','phone','name','company','title','company_size',
        'forget_password','country_id',
        'is_mail_send','should_rate_order_id','jwt','os','app_version','model','firebase_token',
        'reward_points','members','wallet','is_allowed'
    ];

    protected $hidden = [
        'password',
        // 'remember_token',
    ];

    public function getMarketingBrief()
    {
       return $this->hasMany('\App\Models\MemberMarketingBrief','member_id');
    }

}
