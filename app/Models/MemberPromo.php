<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberPromo extends Model
{
    protected $table = 'member_promo';
    const UPDATED_AT = null;
    protected $fillable = [
        'member_id', 'promo_id', 'is_used','used_date','city_id'
    ];

    // public function get_Role()
    // {
    //    return $this->belongsTo(Role::class,'role_id');
    // }

}
