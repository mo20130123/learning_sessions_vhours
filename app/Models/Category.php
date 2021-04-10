<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    // protected $table = 'facilities';
    protected $fillable = [
       'name_en','name_ar','banner', 'status','position'
    ];

    public function path()
    {
       return url("category/{$this->id}-". Str::slug($this->name??$this->name_en) );
    }

    public function getBannerAttribute($value){
        if($value)
          return asset('images/Banner/'.$value);
    }

     public function setBannerAttribute($value)
     {
         if(is_file($value))
         {
             $fileName = 'Banner_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
             $destinationPath = public_path('images/Banner');
             $value->move($destinationPath, $fileName); // uploading file to given path
             $this->attributes['banner'] = $fileName;
         }
     }

    public function getIconAttribute($value){
      if($value)
        return asset('images/Category/icon/'.$value);
    }

     public function setIconAttribute($value)
     {
         if(is_file($value))
         {
             $fileName = 'icon_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
             $destinationPath = public_path('images/Category/icon');
             $value->move($destinationPath, $fileName); // uploading file to given path
             $this->attributes['icon'] = $fileName;
         }
     }


}
