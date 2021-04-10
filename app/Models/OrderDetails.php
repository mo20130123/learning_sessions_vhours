<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

//Notic:- this class uses observe : OrderDetailsObserver

class OrderDetails extends Model
{
    protected $table = 'order_details';
    public $timestamps = false;

    protected $fillable = [
        'order_id' , 'item_type' , 'product_id' , 'product_name_en', 'product_name_ar',
        'price','member_brief','package_type', 'marketing_brief_id' ,'delivery_status'
    ];

    public function path()
    {
       return url("product/{$this->product_id}-". Str::slug($this->product_name_en) );
    }

    public function getImageAttribute($value)
    {
        if($value)
            return asset('images/ProductImages/' . $value);
    }

    public function getMarketingBrief()
    {
       return $this->belongsTo('\App\Models\MemberMarketingBrief','marketing_brief_id');
    }

    public function getOrderDetailsAdminInfo()
    {
       return $this->hasOne('\App\Models\OrderDetailsAdminInfo','order_details_id');
    }

    public function getOrderModifications()
    {
        return $this->hasMany('\App\Models\OrderDetailsModifications','order_details_id');
    }


}
