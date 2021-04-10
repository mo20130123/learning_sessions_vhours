<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Refrence extends Model
{
    protected $guarded = ['id'];

    // public function path()
    // {
    //    return url("security-products/{$this->id}-". Str::slug($this->name??$this->name_en) );
    // }

    public function Images()
    {
        return $this->hasMany('App\RefrenceImages');
    }

    public function getImageAttribute($value){
        return asset('images/Refrence/Images/'.$value);
    }

     public function setImageAttribute($value)
     {
         if(is_file($value))
         {
             $fileName = 'RefrenceImages_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
             $destinationPath = public_path('images/Refrence/Images');
             $value->move($destinationPath, $fileName); // uploading file to given path
             $this->attributes['image'] = $fileName;
         }
     }

    public function getBannerAttribute($value){
        return asset('images/Product/Banner/'.$value);
    }

     public function setBannerAttribute($value)
     {
         if(is_file($value))
         {
             $fileName = 'ProductBanner_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
             $destinationPath = public_path('images/Product/Banner');
             $value->move($destinationPath, $fileName); // uploading file to given path
             $this->attributes['banner'] = $fileName;
         }
     }

    // public function setDescriptionArAttribute($value)
    // {
    //     if($value && $value!= 'undefined')
    //       $value = addcslashes( $value, "\n");
    //       $value = str_replace('"',"",$value);
    //       $this->attributes['description_ar'] =  addcslashes( $value, "\r" );
    // }

    public function setDescriptionArAttribute($value)
    {
        if($value && $value!= 'undefined')
          $this->attributes['description_ar'] =  str_replace('"',"",$value);
    }

    public function setDescriptionEnAttribute($value)
    {
        if($value && $value!= 'undefined')
            $this->attributes['description_en'] =  str_replace('"',"",$value);
    }

    public function setNameArAttribute($value)
    {
        if($value && $value!= 'undefined')
          $this->attributes['name_ar'] =  str_replace('"',"",$value);
    }

    public function setNameEnAttribute($value)
    {
        if($value && $value!= 'undefined')
          $this->attributes['name_en'] =  str_replace('"',"",$value);
    }



}
