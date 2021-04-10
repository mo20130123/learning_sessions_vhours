<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MiniHomeSlider extends Model
{
    protected $table = 'mini_home_slider';
    protected $guarded = ['id'];

    public function getImageAttribute($value){
         return asset('images/miniHomeSlider/'.$value);
   }

    public function setImageAttribute($value)
    {
        if(is_file($value))
        {
           $fileName = 'miniHomeSlider_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
           $destinationPath = public_path('images/miniHomeSlider');
           $value->move($destinationPath, $fileName); // uploading file to given path
           $this->attributes['image'] = $fileName;
        }
    }

}
