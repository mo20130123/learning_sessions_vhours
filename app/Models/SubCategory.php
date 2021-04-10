<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubCategory extends Model
{
    protected $table = 'sub_categories';
    public $timestamps = false;

    protected $fillable = [
        'category_id','name_en','name_ar','banner_ar','banner_en', 'status','position'
    ];

    public function path()
    {
       return url("subCategory/{$this->id}-". Str::slug($this->name??$this->name_en) );
    }


    public function getBannerEnAttribute($value){
      if($value)
        return asset('images/Category/BannerEn/'.$value);
    }

     public function setBannerEnAttribute($value)
     {
         if($value && $value!= 'undefined')
         {
             $fileName = 'BannerEn_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
             $destinationPath = public_path('images/Category/BannerEn');
             $value->move($destinationPath, $fileName); // uploading file to given path
             $this->attributes['banner_en'] = $fileName;
         }
     }

    public function getBannerArAttribute($value){
      if($value)
        return asset('images/Category/BannerAr/'.$value);
    }

     public function setBannerArAttribute($value)
     {
         if($value && $value!= 'undefined')
         {
             $fileName = 'BannerAr_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
             $destinationPath = public_path('images/Category/BannerAr');
             $value->move($destinationPath, $fileName); // uploading file to given path
             $this->attributes['banner_ar'] = $fileName;
         }
     }



}
