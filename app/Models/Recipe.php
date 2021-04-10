<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Recipe extends Model
{
    protected $guarded = ['id'];

    public function path()
    {
       return url("Recipe/details/{$this->id}-". Str::slug($this->name??$this->name_en) );
    }

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

    public function Ingredients()
    {
        return $this->hasMany('App\RecipeIngredients');
    }

    public function Categories()
    {
       return $this->belongsToMany('App\RecipesCategories','recipes_categories_relation','recipe_id','category_id');
    }

    public function Images()
    {
        return $this->hasMany('App\RecipeImages');
    }

    public function setBodyArAttribute($value)
    {
        if($value && $value!= 'undefined'){
          $value = addcslashes( $value, "\n");
          $value = str_replace( array( '"',  '`' , "'" ), ' ', $value);
          $this->attributes['body_ar'] =  addcslashes( $value, "\r" );
        }
    }

    public function setBodyEnAttribute($value)
    {
        if($value && $value!= 'undefined'){
          $value = addcslashes( $value, "\n");
          $value = str_replace( array( '"',  '`' , "'" ), ' ', $value);
          $this->attributes['body_en'] =  addcslashes( $value, "\r" );
        }
    }

    public function setYoutubeLinkAttribute($value)
    {
        if($value=='null' || $value=='undefined' || !$value)
          $this->attributes['youtube_link'] = null;
        else
          $this->attributes['youtube_link'] = $value;
    }

}
