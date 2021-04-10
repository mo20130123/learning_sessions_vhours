<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdProductImages extends Model
{
    protected $table = 'ads_product_images';
    public $timestamps = false;
    protected $fillable = [
        'ads_product_id','image','is_main'
    ];

    public function getImageAttribute($value){
        return asset('images/AdProductImages/'.$value);
    }

     public function setImageAttribute($value)
     {
         if(is_file($value))
         {
             $fileName = 'AdProductImages_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
             $destinationPath = public_path('images/AdProductImages');
             $value->move($destinationPath, $fileName); // uploading file to given path
             $this->attributes['image'] = $fileName;
         }
     }

}
