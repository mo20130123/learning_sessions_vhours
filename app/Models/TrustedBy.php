<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrustedBy extends Model
{
      protected $table = 'trusted_by';

      protected $guarded = ['id'];

      public function getImageAttribute($value){
          return asset('images/TrustedBy/'.$value);
      }

       public function setImageAttribute($value)
       {
           if(is_file($value))
           {
               $fileName = 'TrustedBy_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
               $destinationPath = public_path('images/TrustedBy');
               $value->move($destinationPath, $fileName); // uploading file to given path
               $this->attributes['image'] = $fileName;
           }
       }



}
