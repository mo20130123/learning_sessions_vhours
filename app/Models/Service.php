<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $guarded = ['id'];


    public function getImageAttribute($value){
       return asset('images/Service/'.$value);
    }

     public function setImageAttribute($value)
     {
         if(is_file($value))
         {
             $fileName = 'Service_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
             $destinationPath = public_path('images/Service');
             $value->move($destinationPath, $fileName); // uploading file to given path
             $this->attributes['image'] = $fileName;
         }
     }

}
