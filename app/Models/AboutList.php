<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutList extends Model
{
    protected $table = 'about_list';
    protected $guarded = ['id'];

    public function getImageAttribute($value){
         return asset('images/AboutList/Image/'.$value);
    }

    public function setImageAttribute($value)
    {
        if(is_file($value))
        {
           $fileName = 'AboutList_Image_'.rand(11111,99999).'.'.$value->getClientOriginalExtension();
           $destinationPath = public_path('images/AboutList/Image');
           $value->move($destinationPath, $fileName); // uploading file to given path
           $this->attributes['image'] = $fileName;
        }
    }

    public function getIconAttribute($value){
         return asset('images/AboutList/Icon/'.$value);
    }

    public function setIconAttribute($value)
    {
        if(is_file($value))
        {
           $fileName = 'AboutList_Icon_'.rand(11111,99999).'.'.$value->getClientOriginalExtension();
           $destinationPath = public_path('images/AboutList/Icon');
           $value->move($destinationPath, $fileName); // uploading file to given path
           $this->attributes['icon'] = $fileName;
        }
    }

}
