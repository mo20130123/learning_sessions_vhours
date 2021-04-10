<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title_ar' , 'title_en' ,'pref_description_en','pref_description_ar' ,'description_en','description_ar' ,
        'position','image' , 'status'
    ];


    public function getImageAttribute($value){
        return asset('images/News/'.$value);
    }

     public function setImageAttribute($value)
     {
         if(is_file($value))
         {
             $fileName = 'News_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
             $destinationPath = public_path('images/News');
             $value->move($destinationPath, $fileName); // uploading file to given path
             $this->attributes['image'] = $fileName;
         }
     }

}
