<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefrenceImages extends Model
{
    protected $table = 'refrence_images';
    // public $timestamps = false;
    protected $fillable = [
        'refrence_id','image','is_main'
    ];

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


}
