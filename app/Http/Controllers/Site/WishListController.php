<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\WishList;
use App\Models\SubCategory;
use App\Models\ProductImages;
use App\Models\PagesBanner;
use DB;

class WishListController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth:Member');
    }

     public function index()
     {
         $Banner = PagesBanner::select("imageen as image")
                                 ->where('page','WishList')->first();

         return view( 'Site.wishlist_list',compact('Banner') );
     }

    public function list()
    {
          $lang = \App::getLocale();
          $AuthMember_id = ( auth('Member')->check() )? auth('Member')->id() : 0 ;

         $ShoppingCart = WishList::select(
                          'products.id as id' , 'products.category_id' ,
                          "products.name_$lang as name" ,
                          "products.short_description_$lang as short_description",
                          "products.offer_percentage as offer_percentage",
                          "description_$lang as description",
                          "product_images.image as image",
                           'is_bundle','is_available',
                         DB::raw("if( shopping_cart.product_id , 1,0 ) as in_card"),
                         DB::raw("if( wish_list.product_id , 1,0 ) as in_wish_list")
                      )
                     ->join('products','products.id','wish_list.product_id')
                     ->leftJoin('shopping_cart',function($q)use($AuthMember_id){
                         $q->on('shopping_cart.product_id','products.id')->where('shopping_cart.member_id',$AuthMember_id);
                     })
                     ->leftJoin('product_images',function($q){
                         $q->on('product_images.product_id','products.id')->where('product_images.is_main',1);
                     })
                     ->groupBy('wish_list.id')
                     ->where( 'wish_list.member_id',auth('Member')->id() )
                     // ->where('is_bundle',0)
                     ->limit(60)->paginate(20);

              return response()->json([
                   'status' => 'success',
                   'ShoppingCart_normal' => $ShoppingCart,
              ]);
    }

    public function addOrRemove($product_id)
    {
          $WishList = WishList::where( 'member_id',auth('Member')->id() )->where('product_id',$product_id)->first();

          if($WishList)
          {
              $WishList->delete();
              return response()->json([
                'status' => 'success',
                'case' => 0,
              ]);
          }
          else
          {
              WishList::create([
                'member_id' => auth('Member')->id() ,
                'product_id' => $product_id
              ]);
              return response()->json([
                'status' => 'success',
                'case' => 1,
              ]);
          }
    }

}
