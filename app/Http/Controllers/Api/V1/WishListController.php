<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Product;
use App\WishList;
use App\SubCategory;
use App\ProductImages;
use DB;

class WishListController extends Controller
{
    public function __construct()
    {
        $this->middleware('MemberRequiredJWTAndLang') ;
    }

    public function list(Request $request)
    {
          $lang = $request->lang;
          $AuthMember_id = $request->MemberID;

         $ShoppingCart = WishList::select('products.id as id',
                          "products.name_$lang as name" ,"products.quantity as quantity",
                          "products.short_description_$lang as short_description",
                          'products.price',"products.old_price as old_price","products.discount_percentage as discount_percentage",
                          "description_$lang as description",  "product_images.image as image",
                          'is_chef_rec',
                          DB::raw("if( products.discount_percentage > 0 , 1,0 ) as is_discount"),
                          DB::raw("if( date_add(products.created_at,INTERVAL 1 MONTH) > NOW() , 1,0 ) as is_new"),
                        DB::raw("if( shopping_cart.product_id , 1,0 ) as in_card"),
                        DB::raw("if( wish_list.product_id , 1,0 ) as in_wish_list"),
                        DB::raw("if( shopping_cart.quantity , shopping_cart.quantity,0 ) as in_card_quantity")
                     )

                     ->join('products','products.id','wish_list.product_id')
                     ->leftJoin('shopping_cart',function($q)use($AuthMember_id){
                         $q->on('shopping_cart.product_id','products.id')->where('shopping_cart.member_id',$AuthMember_id);
                     })
                     ->join('product_images','product_images.product_id','products.id')

                     ->groupBy('wish_list.id')
                     ->where( 'wish_list.member_id',$AuthMember_id )
                     ->where('is_bundle',0)
                     ->limit(60)->get();

         $ShoppingCart_bundle = WishList::select('products.id as id',
                          "products.name_$lang as name" ,"products.quantity as quantity",
                          "products.short_description_$lang as short_description",
                          'products.price',"products.old_price as old_price","products.discount_percentage as discount_percentage",
                          "description_$lang as description","bundle_summary_$lang as bundle_summary",
                           'bundle_products_ids', 
                        DB::raw("if( shopping_cart.product_id , 1,0 ) as in_card"),
                        DB::raw("if( wish_list.product_id , 1,0 ) as in_wish_list"),
                        DB::raw("if( shopping_cart.quantity , shopping_cart.quantity,0 ) as in_card_quantity")
                     )

                     ->join('products','products.id','wish_list.product_id')
                     ->leftJoin('shopping_cart',function($q)use($AuthMember_id){
                         $q->on('shopping_cart.product_id','products.id')->where('shopping_cart.member_id',$AuthMember_id);
                     })

                     ->groupBy('wish_list.id')
                     ->where( 'wish_list.member_id',$AuthMember_id )
                     ->where('is_bundle',1)
                     ->limit(60)->get();
                     foreach ($ShoppingCart_bundle as $key => $Product)
                     {
                         $Product->imagess = ProductImages::whereIn('product_id', explode(',', $Product->bundle_products_ids) )
                                                         ->where('is_main',1)->pluck('image');
                         $Product->bundel_first_image = $Product->imagess[0]??'';
                         unset($Product->bundle_products_ids);

                     }

              return response()->json([
                   'status' => 'success',
                   'ShoppingCart_normal' => $ShoppingCart,
                   'SubCategories_bundle' => $ShoppingCart_bundle,
              ]);
    }

    public function addOrRemove(Request $request )
    {
      $validator = \Validator::make($request->all(), [
           'product_id' => 'required',
      ]);
      if ($validator->fails()) {
          return response()->json([ 'status' => 'notValid' ,'status_message' => __('api.notValid') , 'missing_data' => $validator->messages() ]);
      }

         $product_id = $request->product_id;
         $AuthMember_id = $request->MemberID;

          $WishList = WishList::where( 'member_id', $AuthMember_id )->where('product_id',$product_id)->first();

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
                'member_id' => $AuthMember_id ,
                'product_id' => $product_id
              ]);
              return response()->json([
                'status' => 'success',
                'case' => 1,
              ]);
          }
    }

}
