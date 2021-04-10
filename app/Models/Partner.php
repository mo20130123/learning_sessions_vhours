<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $guarded = ['id'];

    public function getImageAttribute($value){
        return asset('images/Partner/'.$value);
    }

     public function setImageAttribute($value)
     {
         if($value && $value!= 'undefined')
         {
             $fileName = 'Partner_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
             $destinationPath = public_path('images/Partner');
             $value->move($destinationPath, $fileName); // uploading file to given path
             $this->attributes['image'] = $fileName;
         }
     }

}
