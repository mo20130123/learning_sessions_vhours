<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Category;
use App\SubCategory;
use App\Setting;
use App\Member;
use App\ShoppingCart;

class SplashController extends Controller
{
    public function __construct()
    {
        $this->middleware('ApiLang') ;
    }

   public function Splash_list(Request $request)
   {
       $lang = $request->lang;
       $jwt = $request->headers->get('jwt');
       $Categories = \App\Category::select( "name_$lang as name",'id','icon' )->where('status',1)->orderBy('position')->get();
       // foreach ($Categories as $key => $Category)
       // {
       //      $Category->SubCategories = SubCategory::select( "name_$lang as name",'id' )
       //                                    ->where('category_id',$Category->id)->where('status',1)->orderBy('position')->get();
       // }
       $reward_points = 0;
       $ShoppingCartCount = 0;
       if($jwt)
       {
           $Member = Member::select('reward_points')->where( 'jwt',$jwt )->first();
           $ShoppingCartCount = ShoppingCart::where( 'member_id',$Member->id )->count();
           if($Member)
              $reward_points = $Member->reward_points;
       }

       $Setting = Setting::where('title','minimum_basket_amount')->orWhere('title','our_phone_1')
                         ->orWhere('title','facebook_link')->orWhere('title','instagram_link')->pluck('value','title');

       return response()->json([
           'status' => 'success',
           'info' => [
              'facebook_link' => $Setting['facebook_link'],
              'instagram_link' => $Setting['instagram_link'],
              'minimum_basket_amount' => $Setting['minimum_basket_amount'],
              'our_phone' => $Setting['our_phone_1'],
           ],
           'member' => [
             'reward_points' => $reward_points,
             'count_cart' => $ShoppingCartCount
           ],
           'Categories' => $Categories ,
       ]);
   }


}
