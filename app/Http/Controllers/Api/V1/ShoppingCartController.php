<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Product;
use App\ShoppingCart;
use App\MemberPromo;
use App\PromoCodes;
use App\FreeTestList;
use App\ProductImages;
use App\MemberAddress;
use DB;

class ShoppingCartController extends Controller
{
    public function __construct()
    {
        $this->middleware('MemberRequiredJWTAndLang')->except('list') ;
        $this->middleware('MemberNotRequiredJWTAndLangAndRate')->only('list') ;
    }


    public function list(Request $request)
    { 
          $AuthMember_id = $request->MemberID;
          $Guest_Cart = $request->Guest_Cart;

          if($AuthMember_id)
          {
              ShoppingCart::delete_outOfStock();
              $ShoppingCart = ShoppingCart::CartFULL($AuthMember_id,false)
                                          ->where('products.is_bundle',0)
                                          ->limit(200)
                                          ->get();

              $ShoppingCart_bundle = ShoppingCart::CartFULL($AuthMember_id,false)
                                                 ->where('products.is_bundle',1)
                                                 ->limit(200)
                                                 ->get();
          }
          else
          {
              $inCartProductsIds = [];
              if($Guest_Cart)
                foreach ($Guest_Cart as $item) {
                  array_push($inCartProductsIds,$item['id']);
                }

               $ShoppingCart = ShoppingCart::CartFULLGuest($inCartProductsIds,'product')->get();
               $ShoppingCart_bundle = ShoppingCart::CartFULLGuest($inCartProductsIds,'bundle')->get();
          }

          foreach ($ShoppingCart as $key => $Product)
          {
              if($Guest_Cart)
                foreach ($Guest_Cart as $Guest_Cart_item)
                {
                   if($Guest_Cart_item['id'] == $Product->id)
                   {
                       $Product->in_card_quantity = $Guest_Cart_item['in_card_quantity'];
                       $Product->cheese_weight = $Guest_Cart_item['cheese_weight']??null;
                       $Product->cheese_type = $Guest_Cart_item['cheese_type']??null;
                   }
                }
          }

         foreach ($ShoppingCart_bundle as $key => $Product)
         {
               if($Guest_Cart)
                 foreach ($Guest_Cart as $Guest_Cart_item)
                 {
                    if($Guest_Cart_item['id'] == $Product->id)
                    {
                        $Product->in_card_quantity = $Guest_Cart_item['in_card_quantity'];
                        $Product->cheese_weight = $Guest_Cart_item['cheese_weight']??null;
                        $Product->cheese_type = $Guest_Cart_item['cheese_type']??null;
                    }
                 }

             $Product->imagess = ProductImages::whereIn('product_id', explode(',', $Product->bundle_products_ids) )
                                             ->where('is_main',1)->pluck('image');
             $Product->bundel_first_image = $Product->imagess[0]??'';
             unset($Product->bundle_products_ids);
             unset($Product->image);
         }

         // $Address = MemberAddress::select('id','city_id','district_id','address','street','building_no','apartment_no')
         $Address = MemberAddress::select('id','address')
                                 ->where('member_id',$request->Member->id??null)->get();

         $chekPromo = MemberPromo::where( 'member_id',auth('Member')->id() )->where('is_used',0)->first();

         if($chekPromo)
         {
           $promo = PromoCodes::find($chekPromo->promo_id);
           $promo_discount_percentage = $promo->discount_percentage??0;
         }
         else {
           $promo_discount_percentage = 0;
         }

          return response()->json([
              'status' => 'success',
              'promo_discount_percentage' => $promo_discount_percentage,
              'Address' => $Address,
              'ShoppingCart_products' => $ShoppingCart,
              'ShoppingCart_bundles' => $ShoppingCart_bundle,
          ]);
    }


      public function add(Request $request)
      {
          $validator = \Validator::make($request->all(), [
            'product_id' => 'required',
            'quantity' => 'numeric|min:1',
            'cheese_weight' => 'nullable|in:250gm,500gm,750gm,1KG',
            'cheese_type' => 'nullable|in:block,sliced,shredded,cubes,tube'
          ]);
          if ($validator->fails()) {
              return response()->json([ 'status' => 'notValid' ,'status_message' => __('api.notValid') , 'missing_data' => $validator->messages() ]);
          }

            $AuthMember_id = $request->MemberID;

            $ShoppingCart = ShoppingCart::where( 'member_id',$AuthMember_id )->where('product_id',$request->product_id)->first();
            $product = Product::findOrFail($request->product_id);
            if($ShoppingCart){
                if($request->quantity) //a spisifc quantity
                {
                    if($product->quantity >= $request->quantity)//there is available quantity
                    {
                      $ShoppingCart->update([ 'quantity' => (int)$request->quantity ]);
                      $ShoppingCart->quantity = (int)$request->quantity;
                      if($product->have_type_and_weight)
                      {
                           $ShoppingCart->cheese_weight = $request->cheese_weight??'250gm';
                           $ShoppingCart->cheese_type = $request->cheese_type??'block';
                      }
                      $ShoppingCart->save();
                    }
                    else //no available quantity
                    {
                        return response()->json([
                            'status' => 'failed',
                            'status_message' => __('api.Max in Stock 2',['quantity'=>$product->quantity]),
                            'case' => 'no available quantity',
                            'in_card_quantity' => $ShoppingCart->quantity,
                        ]);
                    }
                }
                else
                {
                    if($product->quantity > $ShoppingCart->quantity){//there is available quantity
                      $ShoppingCart->increment('quantity');
                    }
                    else //no available quantity
                    {
                        return response()->json([
                          'status' => 'failed',
                          'status_message' => __('api.Max in Stock 2',['quantity'=>$product->quantity]),
                          'case' => 'no available quantity',
                          'in_card_quantity' => $ShoppingCart->quantity,
                        ]);
                    }
                }
            }//End if($ShoppingCart)
            else {
               if($product->quantity > 0){//there is available quantity
                    $the_data = [
                        'member_id' => $AuthMember_id,
                        'product_id' => $request->product_id,
                        'quantity' => $request->quantity??1,
                        'cheese_weight' => $product->have_type_and_weight ? ($request->cheese_weight??'250gm') : null,
                        'cheese_type' => $product->have_type_and_weight ? ($request->cheese_type??'block') : null,
                    ];

                   $ShoppingCart = ShoppingCart::create($the_data);
               }
            }
            return response()->json([
              'status' => 'success',
              'status_message' => __('api.Added to cart'),
              'case' => 'added',
              'in_card_quantity' => $ShoppingCart->quantity,
            ]);
      }

      public function remove(Request $request)
      {
          $validator = \Validator::make($request->all(), [
               'product_id' => 'required',
          ]);
          if ($validator->fails()) {
              return response()->json([ 'status' => 'notValid' ,'status_message' => __('api.notValid') , 'missing_data' => $validator->messages() ]);
          }

             $product_id = $request->product_id;
             $AuthMember_id = $request->MemberID;
           ShoppingCart::where( 'member_id',$AuthMember_id )->where('product_id',$product_id)->delete();
           return response()->json([
             'status' => 'success',
             'status_message' => __('api.product has deleted from the cart'),
           ]);
      }


}
