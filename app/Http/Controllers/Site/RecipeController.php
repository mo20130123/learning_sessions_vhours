<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\PagesBanner;
use App\RecipeIngredients;
use App\RecipeImages;
use App\Recipe;
use App\Setting;
use App\ShoppingCart;
use App\RecipesCategories;


class RecipeController extends Controller
{
      public function index($cat_id=null)
      {
          $lang = \App::getLocale();
          $Banner = PagesBanner::select("imageen as image") // ,"title_$lang as title","body_$lang as body"
                                    ->where('page','Recipe')->first();
          $RecipesCategories = RecipesCategories::select('id',"name_$lang as name")
                                                ->orderBy('position')->where('status',1)->get();

          return view('Site.Recipes.Recipe_list',compact('Banner','RecipesCategories','cat_id' )  );
      }

      public function show($id)
      {
          $lang = \App::getLocale();
          $Recipe = Recipe::select('id',"name_$lang as name" ,"body_$lang as body","time_$lang as time","servings_$lang as servings",'youtube_link' )
                          ->whereId($id)
                          ->where('status',1)->first();
          $images = RecipeImages::select('id','image')
                                  ->where('recipe_id',$id)
                                  ->orderBy('id')
                                  ->get();
          $Ingredients = RecipeIngredients::select("text_$lang as text",'id','product_id','quantity')
                         ->where('recipe_id',$id)
                         ->orderBy('id')
                         ->get();

          $Banner = PagesBanner::select("imageen as image") // ,"title_$lang as title","body_$lang as body"
                                    ->where('page','Recipe')->first();
          $realted_Recipes = Recipe::select('recipes.id as id',"name_$lang as name",'recipe_images.image as image' )
             ->leftJoin('recipe_images',function($q){
                  $q->on('recipe_images.recipe_id','recipes.id')->where('recipe_images.is_main',1);
             })
             ->where('status',1)
             ->where('recipes.id','!=',$Recipe->id)
             ->orderBy('position')
             ->limit(15)->get();
          return view('Site.Recipes.Recipe_details',compact('Recipe','Banner','images','realted_Recipes','Ingredients' ) );
      }

      public function get_list(Request $request)
      {
          $lang = \App::getLocale();
          $selcted_cat_id = $request->selcted_cat_id;
          return Recipe::select('recipes.id as id',"name_$lang as name", 'recipe_images.image as image' )
              ->leftJoin('recipe_images',function($q){
                   $q->on('recipe_images.recipe_id','recipes.id')->where('recipe_images.is_main',1);
              })
             ->whereHas('Categories', function($q) use($selcted_cat_id) {
               if($selcted_cat_id)
                  $q->where('category_id', $selcted_cat_id);
              })
             ->groupBy('recipes.id')
             ->where('status',1)
             ->orderBy('position')
             ->paginate(25);
      }

      public function add_choosen_Ingredients(Request $request)
      {
         $choosen_Ingredients = json_decode($request->choosen_Ingredients) ;
         $Ingredients = RecipeIngredients::select( 'recipe_ingredients.id','product_id','recipe_ingredients.quantity')
                        ->join('products','products.id','recipe_ingredients.product_id')
                        ->groupBy('recipe_ingredients.id')
                        ->whereIn('recipe_ingredients.id',$choosen_Ingredients)
                        ->whereRaw('recipe_ingredients.quantity <= products.quantity')
                        ->get();
             foreach ($Ingredients as $Ingredient)
            {
               $find = ShoppingCart::where('member_id',auth('Member')->id())->where('product_id',$Ingredient->product_id)->first();
                 if(!$find){
                     ShoppingCart::create([
                        'member_id' => auth('Member')->id() ,
                        'product_id' => $Ingredient->product_id,
                        'quantity' => $Ingredient->quantity,
                        'cheese_weight' => null,
                        'cheese_type' => null,
                     ]);
                 }
                 else {
                     $find->update([
                       'quantity' => $find->quantity + $Ingredient->quantity,
                       'cheese_weight' => null,
                       'cheese_type' => null,
                     ]);
                 }
            }

            return response()->json([
               'status' => 'success',
           ]);
      }

      public function get_Ingredients_by_ids(Request $request)
      {
          $choosen_Ingredients = json_decode($request->choosen_Ingredients);
          $Ingredients = RecipeIngredients::select( 'product_id as id','recipe_ingredients.quantity')
                         ->leftJoin('products','products.id','recipe_ingredients.product_id')
                         ->groupBy('recipe_ingredients.id')
                         ->whereRaw('recipe_ingredients.quantity <= products.quantity')
                         ->whereIn('recipe_ingredients.id',$choosen_Ingredients)
                         ->get();

           return response()->json([
              'status' => 'success',
              'Ingredients' => $Ingredients
          ]);
      }

}
