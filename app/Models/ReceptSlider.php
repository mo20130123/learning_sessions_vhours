<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceptSlider extends Model
{
    protected $table = 'recepe_sliders';

    protected $fillable = [
        'title_en','title_ar','body_en','body_ar','link' ,'image', 'status','position'
    ];

    public function name()
    {
       return $this->f_name.' '.$this->l_name;
    }

    public function getImageAttribute($value){
        return asset('images/ReceptSlider/'.$value);
    }

     public function setImageAttribute($value)
     {
         if(is_file($value))
         {
             $fileName = 'ReceptSlider_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
             $destinationPath = public_path('images/ReceptSlider');
             $value->move($destinationPath, $fileName); // uploading file to given path
             $this->attributes['image'] = $fileName;
         }
     }



}
