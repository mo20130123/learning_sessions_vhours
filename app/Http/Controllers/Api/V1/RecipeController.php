<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\PagesBanner;
use App\ReceptSlider;
use App\RecipesCategories;
use App\RecipeIngredients;
use App\RecipeImages;
use App\Recipe;
use App\Setting;
use App\ShoppingCart;

class RecipeController extends Controller
{
    public function __construct()
    {
        $this->middleware('MemberNotRequiredJWTAndLangAndRate') ;
    }

    public function RecipesCategoriesList(Request $request)
    {
        $lang = $request->lang;
        $RecipesCategories = RecipesCategories::select('id', "name_$lang as name")
                                              ->orderBy('position')->where('status', 1)->get();
        return response()->json([
            'status' => 'success',
            'RecipesCategories' => $RecipesCategories,
        ]);
    }

    public function get_list(Request $request)
    {
        $lang = $request->lang;
        $selcted_cat_id = $request->recipe_cat_id;

        $Recipe = Recipe::select('recipes.id as id',"name_$lang as name", 'recipe_images.image as image' )
            ->leftJoin('recipe_images',function($q){
                 $q->on('recipe_images.recipe_id','recipes.id')->where('recipe_images.is_main',1);
            })
            ->whereHas('Categories', function ($q) use ($selcted_cat_id) {
                if ($selcted_cat_id)
                    $q->where('category_id', $selcted_cat_id);
            })
           ->groupBy('recipes.id')
           ->where('status',1)
           ->orderBy('position')
           ->paginate();
        return collect(['status' => 'success'])->merge($Recipe);
    }

    public function show(Request $request,$id)
    {
       $lang = $request->lang;
       $AuthMember_id = $request->MemberID;
        $lang = \App::getLocale();
        $Recipe = Recipe::select('id',"name_$lang as name" ,"body_$lang as body","time_$lang as time","servings_$lang as servings" )
                        ->whereId($id)
                        ->where('status',1)->first();
                if(!$Recipe){
                  return response()->json([
                      'status' => 'failed',
                      'error' => 'wrong Recipe id'
                  ]);
                }
        $images = RecipeImages::select('id','image')
                                ->where('recipe_id',$id)
                                ->orderBy('id')
                                ->get();
        $Ingredients = RecipeIngredients::select("text_$lang as text",'id','product_id','quantity')
                       ->where('recipe_id',$id)
                       ->orderBy('id')
                       ->get();


        $realted_Recipes = Recipe::select('recipes.id as id',"name_$lang as name",'recipe_images.image as image' )
           ->leftJoin('recipe_images',function($q){
                $q->on('recipe_images.recipe_id','recipes.id')->where('recipe_images.is_main',1);
           })
           ->where('status',1)
           ->where('recipes.id','!=',$Recipe->id)
           ->orderBy('position')
           ->limit(4)->get();

           return response()->json([
               'status' => 'success',
               'Recipe' => $Recipe ,
               'images' => $images ,
               'Ingredients' => $Ingredients ,
               'relatedRecipes' => $realted_Recipes ,
           ]);
    }



    public function add_choosen_Ingredients(Request $request)
    {
       $AuthMember_id = $request->MemberID;
       // $choosen_Ingredients = json_decode($request->choosen_Ingredients) ;
       $choosen_Ingredients =  ($request->choosen_Ingredients) ;
       $Ingredients = RecipeIngredients::select( 'id','product_id','quantity')
                      ->whereIn('id',$choosen_Ingredients)
                      ->get();

          foreach ($Ingredients as $Ingredient)
          {
             if($Ingredient->product_id)
              ShoppingCart::create([
                 'member_id' => $AuthMember_id ,
                 'product_id' => $Ingredient->product_id,
                 'quantity' => $Ingredient->quantity,
                 'cheese_weight' => null,
                 'cheese_type' => null,
              ]);
          }

          return response()->json([
             'status' => 'success',
             'status_message' => __('api.items has been added to the cart')
         ]);
    }


}
