<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCodes extends Model
{
    protected $table = 'promo_codes';
    protected $fillable = [
        'code','discount_percentage', 'from_date','to_date', 'status', 'city_id' ,
        'actual_number_of_usage','allowed_number_of_usage','allowed_number_per_user'
    ];


}
