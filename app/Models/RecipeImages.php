<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeImages extends Model
{
    protected $table = 'recipe_images';
    public $timestamps = false;
    protected $fillable = [
        'recipe_id','image','is_main'
    ];

    public function getImageAttribute($value){
         return asset('images/RecipeImages/'.$value);
    }

    public function setImageAttribute($value)
    {
        if(is_file($value))
        {
           $fileName = 'RecipeImages_'.rand(11111,99999).'.'.$value->getClientOriginalExtension(); // renameing image
           $destinationPath = public_path('images/RecipeImages');
           $value->move($destinationPath, $fileName); // uploading file to given path
           $this->attributes['image'] = $fileName;
        }
    }

}
