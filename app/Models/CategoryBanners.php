<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryBanners extends Model
{
      protected $table = 'categories_banners';

      protected $guarded = ['id'];

      public function getImageAttribute($value){
          return asset('images/CategoryBanners/'.$value);
      }
      public function getImageEnAttribute($value){
          return asset('images/CategoryBanners/'.$value);
      }
      public function getImageArAttribute($value){
          return asset('images/CategoryBanners/'.$value);
      }

       public function setImageEnAttribute($value)
       {
           if(is_file($value))
           {
               $fileName = 'CategoryBannersEn_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
               $destinationPath = public_path('images/CategoryBanners');
               $value->move($destinationPath, $fileName); // uploading file to given path
               $this->attributes['image_en'] = $fileName;
           }
       }

       public function setImageArAttribute($value)
       {
           if(is_file($value))
           {
               $fileName = 'CategoryBannersAr_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
               $destinationPath = public_path('images/CategoryBanners');
               $value->move($destinationPath, $fileName); // uploading file to given path
               $this->attributes['image_ar'] = $fileName;
           }
       }

       public function setLinkAttribute($value)
       {
           if($value && $value!= 'undefined'){
             $value = addcslashes( $value, "\n");
             $value = str_replace( array( '"',  '`' , "'" ), ' ', $value);
             $this->attributes['link'] =  addcslashes( $value, "\r" );
           }
       }

}
