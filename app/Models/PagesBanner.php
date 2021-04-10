<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagesBanner extends Model
{
    protected $table = 'pages_banners';
    public $timestamps = false;

    protected $fillable = [
        'page','imageen','imagear', 'title', 'body','link','position'
    ];

    public function getImageAttribute($value){
        return asset('images/PagesBanner/'.$value);
    }

    public function getImageenAttribute($value){
        return asset('images/PagesBanner/'.$value);
    }

    public function getImagearAttribute($value){
        return asset('images/PagesBanner/'.$value);
    }

     public function setImageenAttribute($value)
     {
         if($value && $value!= 'undefined')
         {
             $fileName = 'PagesBanner_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
             $destinationPath = public_path('images/PagesBanner');
             $value->move($destinationPath, $fileName); // uploading file to given path
             $this->attributes['imageen'] = $fileName;
         }
     }

     public function setImagearAttribute($value)
     {
         if($value && $value!= 'undefined')
         {
             $fileName = 'PagesBanner_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
             $destinationPath = public_path('images/PagesBanner');
             $value->move($destinationPath, $fileName); // uploading file to given path
             $this->attributes['imagear'] = $fileName;
         }
     }
}
