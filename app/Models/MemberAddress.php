<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberAddress extends Model
{
    protected $table = 'member_address';
    // public $timestamps = false;

    protected $fillable = [
        'member_id' , 'address' , 'street' , 'building_no' , 'apartment_no' , 'city_id' , 'district_id'
    ];



}
