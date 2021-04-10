<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = [
        'city_id','name_en','name_ar', 'status'
    ];
}
