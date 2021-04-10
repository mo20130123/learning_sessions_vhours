<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RecipesCategories extends Model
{
    protected $table = 'recipes_categories';
    protected $guarded = ['id'];

    public function path()
    {
       return url("Recipe/{$this->id}-". Str::slug($this->name??$this->name_en) );
    }

    public function Categories()
    {
       return $this->belongsToMany('App\Recipe','recipes_categories_relation','category_id','recipe_id');
    }

}
