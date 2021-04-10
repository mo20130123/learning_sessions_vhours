<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSlider extends Model
{
    protected $table = 'home_sliders';
    const UPDATED_AT = null;
    protected $fillable = [
        'title','image_en','image_ar','link','position','status'
    ];

    public function getImageEnAttribute($value){
        return asset('images/HomeSlider/'.$value);
    }

    public function getImageAttribute($value){
        if($value)
          return asset('images/HomeSlider/'.$value);
    }

     public function setImageEnAttribute($value)
     {
         if(is_file($value))
         {
             $fileName = 'HomeSliderEn_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
             $destinationPath = public_path('images/HomeSlider');
             $value->move($destinationPath, $fileName); // uploading file to given path
             $this->attributes['image_en'] = $fileName;
         }
     }

    public function getImageArAttribute($value){
        return asset('images/HomeSlider/'.$value);
    }

     public function setImageArAttribute($value)
     {
         if(is_file($value))
         {
             $fileName = 'HomeSliderAr_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
             $destinationPath = public_path('images/HomeSlider');
             $value->move($destinationPath, $fileName); // uploading file to given path
             $this->attributes['image_ar'] = $fileName;
         }
     }

}
