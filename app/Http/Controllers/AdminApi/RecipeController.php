<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\vueAdminController;


use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
//
use App\Recipe;
use App\RecipeIngredients;
use App\RecipeImages;
use App\RecipesCategories;

class RecipeController extends vueAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->set_model_name('Recipe');

        $this->vars_for_selections =  [
           'RecipesCategories' => \App\RecipesCategories::select("name_en as label",'id as value')->get()
        ];

        $this->search_attrs =  [
             'id' , 'name_en' , 'name_ar'
        ];

        $this->sort_attrs =  [
             'id' , 'name_en as name' , 'position' , 'status'
        ];


    }//End __construct

    //---api----
    public function get_list(Request $request)
    {
         $search = $request->search;
         $category_id = $request->category_id;

         return Recipe::select('recipes.*','recipe_images.image as image')
                     ->leftJoin('recipe_images',function($q){
                          $q->on('recipe_images.recipe_id','recipes.id')->where('recipe_images.is_main',1);
                     })
                     ->groupBy('recipes.id')
         ->where(function($q)use($search){
              if ($search) {
                  $q->where('recipes.id',$search)
                    ->orWhere('name_en','like','%'.$search.'%')->orWhere('name_en','like','%'.$search.'%');
              }//End if
           })
           ->where(function($Oq)use($category_id){
             if($category_id)
                $Oq->whereHas('Categories', function($Iq) use ($category_id) {
                      $Iq->where('category_id',$category_id);
                });
           })
           ->latest('recipes.id')->paginate();
    }

    public function store(Request $request)
    {
          $validator = \Validator::make($request->all(),[
              'recipes_category_ids' => 'required',
              'name_en' => 'required',
              'name_ar' => 'required',
              'time_en' => 'required',
              'time_ar' => 'required',
              'servings_en' => 'required',
              'servings_ar' => 'required',
              'body_en' => 'required',
              'body_ar' => 'required',
              'youtube_link' => '',
              'images.*' => 'max:500'
          ]);

          if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

          $images_arr = [];
          foreach ($request->images as $key => $image)
          {
             if($key == $request->is_main)
             {
                array_push($images_arr,[
                   'image' => $image,
                   'is_main' => 1
                ]);
             }
             else {
                array_push($images_arr,[
                   'image' => $image,
                   'is_main' => 0
                ]);
             }
          }

          $ingredients = $request->Ingredients ? json_decode($request->Ingredients,true):null ;
          $ingredientsData = [];
            foreach ($ingredients as $ingredient)
            {
                array_push($ingredientsData,[
                  'text_en' => $ingredient['text_en'] ,
                  'text_ar' => $ingredient['text_ar'] ,
                  'quantity' => $ingredient['quantity'] ,
                  'product_id' => $ingredient['product_id']
                ]);
            }

          $Recipe = Recipe::create([
              'name_en' => $request->name_en ,
              'name_ar' => $request->name_ar ,
              'time_en' => $request->time_en ,
              'time_ar' => $request->time_ar ,
              'servings_en' => $request->servings_en ,
              'servings_ar' => $request->servings_ar ,
              'body_en' => $request->body_en ,
              'body_ar' => $request->body_ar ,
              'youtube_link' => $request->youtube_link ,
          ]);

          if($request->recipes_category_ids)
            $Recipe->Categories()->attach(explode(',',$request->recipes_category_ids));

          $Recipe->Images()->createMany($images_arr);

          $Recipe->Ingredients()->createMany($ingredientsData);
          $Recipe->status = 1;
          return response()->json([
            'status' => 'success',
            'data' => $Recipe
          ]);
    }


    //--api--
    public function update(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'id' => 'required',
            'recipes_category_ids' => 'required',
            'name_en' => 'required',
            'name_ar' => 'required',
            'time_en' => 'required',
            'time_ar' => 'required',
            'servings_en' => 'required',
            'servings_ar' => 'required',
            'body_en' => 'required',
            'body_ar' => 'required',
            'youtube_link' => '',
            'images.*' => 'max:500'
        ]);

        if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

        $Recipe = Recipe::findOrFail($request->id);
        $Recipe->update([
            'name_en' => $request->name_en ,
            'name_ar' => $request->name_ar ,
            'time_en' => $request->time_en ,
            'time_ar' => $request->time_ar ,
            'servings_en' => $request->servings_en ,
            'servings_ar' => $request->servings_ar ,
            'body_en' => $request->body_en ,
            'body_ar' => $request->body_ar ,
            'youtube_link' => $request->youtube_link ,
        ]);

         $Recipe->Categories()->sync(explode(',',$request->recipes_category_ids));

        RecipeImages::where('recipe_id',$request->id)->update(['is_main'=>0]);
        if($request->is_main){
          $update_is_main = RecipeImages::find($request->is_main);
          if($update_is_main)
             $update_is_main->update(['is_main'=>1]);
        }
        if(isset($request->old_images_ids)){
          RecipeImages::where('recipe_id',$request->id)->whereNotIn('id',array_filter($request->old_images_ids))->delete();
        }
        else
          RecipeImages::where('recipe_id',$request->id)->delete();


        if(isset($request->images))
        {
             $images_arr = [];
             foreach ($request->images as $key => $image)
             {
                $Recipe->Images()->create([
                    'image' => $image
                ]);
             }
        }

        $check_is_main = RecipeImages::where('recipe_id',$request->id)->where('is_main',1)->first();
        if(!$check_is_main){
          $first_Image = RecipeImages::where('recipe_id',$request->id)->first();
          if($first_Image)
             $first_Image->update(['is_main'=>1]);
        }

        $Images = RecipeImages::select('*','id as cc')->where('recipe_id',$request->id)->get();


        if(isset($request->old_ingredient_ids)){
          RecipeIngredients::where('recipe_id',$request->id)->whereNotIN('id',array_filter($request->old_ingredient_ids))->delete();
        }
        else {
          RecipeIngredients::where('recipe_id',$request->id)->delete();
        }


        $ingredients = $request->Ingredients ? json_decode($request->Ingredients,true):null ;
          foreach ($ingredients as $ingredient)
          {
              $ingredientsData = [
                'recipe_id' => $Recipe->id ,
                'text_en' => $ingredient['text_en'] ,
                'text_ar' => $ingredient['text_ar'] ,
                'quantity' => $ingredient['quantity'] ,
                'product_id' => $ingredient['product_id']??null
              ];
              if(isset($ingredient['id']))
              {
                $Ingredient = RecipeIngredients::find($ingredient['id']);
                if($Ingredient)
                  $Ingredient->update($ingredientsData);
              }
              else
              {
                 $Ingredient = RecipeIngredients::create($ingredientsData);
              }
          }

        return response()->json([
          'status' => 'success',
          'data' => $Recipe
        ]);
    }


    public function show($id)
    {
        $Recipe = Recipe::findOrFail($id);
        $Recipe->recipes_category_ids = $Recipe->Categories()->allRelatedIds()->toArray();
        $Ingredients = RecipeIngredients::select('recipe_ingredients.id as cc','recipe_ingredients.*','products.name_en as name',
                                         \DB::raw("false as showLoder"),\DB::raw("true as isIdCorrect") )
                                 ->leftJoin('products','products.id','recipe_ingredients.product_id')
                                 ->groupBy('recipe_ingredients.id')
                                 ->where('recipe_ingredients.recipe_id',$id)
                                 ->get();
         $Images = RecipeImages::select('*','id as cc')->where('recipe_id',$id)->get();

        return response()->json([
          'status' => 'success',
          'Recipe' => $Recipe,
          'Ingredients' => $Ingredients,
          'Images' => $Images
        ]);
    }



}
