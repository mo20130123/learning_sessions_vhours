<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    protected $fillable = [
        'category_id','sub_category_id','banner_en','banner_ar','name_en','name_ar',
        'og_description_ar','og_description_en',
        'logo', 'status','position'
    ];

    public function path()
    {
       return url("brand/{$this->id}-". Str::slug($this->name??$this->name_en) );
    }

    public function getLogoAttribute($value){
      if($value)
        return asset('images/Brand/logo/'.$value);
    }

     public function setLogoAttribute($value)
     {
         if($value && $value!= 'undefined')
         {
             $fileName = 'Brand_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
             $destinationPath = public_path('images/Brand/logo');
             $value->move($destinationPath, $fileName); // uploading file to given path
             $this->attributes['logo'] = $fileName;
         }
     }


    public function getBannerEnAttribute($value){
      if($value)
        return asset('images/Brand/BannerEn/'.$value);
    }

     public function setBannerEnAttribute($value)
     {
         if($value && $value!= 'undefined')
         {
             $fileName = 'BannerEn_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
             $destinationPath = public_path('images/Brand/BannerEn');
             $value->move($destinationPath, $fileName); // uploading file to given path
             $this->attributes['banner_en'] = $fileName;
         }
     }

    public function getBannerArAttribute($value){
      if($value)
        return asset('images/Brand/BannerAr/'.$value);
    }

     public function setBannerArAttribute($value)
     {
         if($value && $value!= 'undefined')
         {
             $fileName = 'BannerAr_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
             $destinationPath = public_path('images/Brand/BannerAr');
             $value->move($destinationPath, $fileName); // uploading file to given path
             $this->attributes['banner_ar'] = $fileName;
         }
     }

}
