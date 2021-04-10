<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    protected $table = 'product_images';
    public $timestamps = false;
    protected $fillable = [
        'product_id','image','is_main'
    ];

    public function getImageAttribute($value){
        return asset('images/ProductImages/'.$value);
    }

     public function setImageAttribute($value)
     {
         if(is_file($value))
         {
             $fileName = 'ProductImages_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
             $destinationPath = public_path('images/ProductImages');
             $value->move($destinationPath, $fileName); // uploading file to given path
             $this->attributes['image'] = $fileName;
         }
     }

}
