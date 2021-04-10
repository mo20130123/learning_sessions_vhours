<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Provider extends Model
{
    protected $guarded = ['id'];

    public function getLogoAttribute($value){
      if($value)
        return asset('images/Provider/logo/'.$value);
    }

     public function setLogoAttribute($value)
     {
         if(is_file($value))
         {
             $fileName = 'Provider_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
             $destinationPath = public_path('images/Provider/logo');
             $value->move($destinationPath, $fileName); // uploading file to given path
             $this->attributes['logo'] = $fileName;
         }
     }

     public function getImageAttribute($value){
        if($value)
          return asset('images/Provider/'.$value);
     }

     public function setImageAttribute($value)
     {
         if(is_file($value))
         {
            $fileName = 'Provider_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
            $destinationPath = public_path('images/Provider');
            $value->move($destinationPath, $fileName); // uploading file to given path
            $this->attributes['image'] = $fileName;
         }
     }

     public function path()
     {
        return url("Providers/{$this->id}-". Str::slug($this->name??$this->name_en) );
     }

}
