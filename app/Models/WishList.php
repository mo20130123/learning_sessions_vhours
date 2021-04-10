<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    protected $table = 'wish_list';
    const UPDATED_AT = null;

    protected $fillable = [
        'member_id' , 'product_id'
    ];

    public function getImageAttribute($value){
         if($value)
          return asset('images/ProductImages/'.$value);
    }

    public function getImagesAttribute($value){
         if($value)
         return explode(',', $value) ;
    }
}
