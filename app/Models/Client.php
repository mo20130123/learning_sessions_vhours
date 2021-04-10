<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = ['id'];

    public function getImageAttribute($value){
         return asset('images/Client/'.$value);
   }

    public function setImageAttribute($value)
    {
        if(is_file($value))
        {
           $fileName = 'Client_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
           $destinationPath = public_path('images/Client');
           $value->move($destinationPath, $fileName); // uploading file to given path
           $this->attributes['image'] = $fileName;
        }
    }

}
