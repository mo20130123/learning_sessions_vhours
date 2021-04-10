<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeIngredients extends Model
{
    protected $table = 'recipe_ingredients';
    public $timestamps = false;
    protected $guarded = ['id'];


    public function Recipe()
    {
        return $this->belongsTo('App\Recipe');
    }

}
