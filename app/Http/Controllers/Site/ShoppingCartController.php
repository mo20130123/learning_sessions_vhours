<?php
namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\ShoppingCart;
use App\Models\MemberPromo;
use App\Models\PromoCodes;
use App\Models\ProductImages;
use App\Models\MemberMarketingBrief;
use DB;

class ShoppingCartController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth:Member');
       // $this->middleware('CheckIfAddressCorrect')->only('index');
    }

   // public function cart_page()
   // {
   //      $cart_product_ids = ShoppingCart::where( 'member_id',auth('Member')->id() )->pluck('product_id');
   //
   //        $missing_products = Product::productsFULL()
   //              ->where('products.is_combo',0)
   //              ->whereNotIn('products.id',$cart_product_ids)
   //              ->orderBy('products.position')->limit(8)
   //              ->get();
   //
   //      return view('Site.ShoppingCart' ,compact('missing_products' ));
   //  }

   public function OrderSummary_page()
   {
       $lang = \App::getLocale();
       $ShoppingCart = ShoppingCart::CartFULL()->get();
       $Briefs = MemberMarketingBrief::select("name",'id')
                        ->where('member_id',auth('Member')->id())->get();
       // return $ShoppingCart;
        return view('Site.ShoppingCart.OrderSummary' ,compact('ShoppingCart','Briefs' ));
    }

   public function checkout_page()
   {
        $lang = \App::getLocale();
        $ShoppingCart = ShoppingCart::CartFULL()->get();

        $chekPromo = MemberPromo::where( 'member_id',auth('Member')->id() )->where('is_used',0)->first();

        if($chekPromo)
        {
          $promo = PromoCodes::find($chekPromo->promo_id);
          $promo_discount_percentage = $promo->discount_percentage??0;
        }
        else {
          $promo_discount_percentage = 0;
        }

        return view('Site.ShoppingCart.checkout' ,compact('ShoppingCart','promo_discount_percentage'   ));
    }

    public function list(Request $request)
    {
         $AuthMember_id = ( auth('Member')->check() )? auth('Member')->id() : 0 ;
         $Guest_Cart = $request->Guest_Cart;

          if($AuthMember_id)
          {
              ShoppingCart::delete_outOfStock();
              $ShoppingCart = ShoppingCart::CartFULL()
                                          ->where('products.is_bundle',0)
                                          ->paginate(200);

              $ShoppingCart_bundle = ShoppingCart::CartFULL()
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

               $ShoppingCart = ShoppingCart::CartFULLGuest($inCartProductsIds,'product')->paginate(200);
               $ShoppingCart_bundle = ShoppingCart::CartFULLGuest($inCartProductsIds,'bundle')->get();
          }

         foreach ($ShoppingCart as $key => $Product)
         {
             if($Guest_Cart)
               foreach ($Guest_Cart as $Guest_Cart_item)
               {
                  if($Guest_Cart_item['id'] == $Product->id)
                  {
                      $Product->in_card_quantity = $Guest_Cart_item['quantity'];
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
                      $Product->in_card_quantity = $Guest_Cart_item['quantity'];
               }

             $Product->imagess = ProductImages::whereIn('product_id', explode(',', $Product->bundle_products_ids) )
                                              ->where('is_main',1)->pluck('image');
         }

          return response()->json([
              'status' => 'success',
              'ShoppingCart_normal' => $ShoppingCart,
              'SubCategories_bundle' => $ShoppingCart_bundle,
          ]);
    }



    public function add(Request $request)
    {
          $data = $request->validate([
            'product_id' => 'required',
            'type' => 'required',
            'package' => '',
            'brief_text' => '',
            'marketing_brief' => '',
            'attachment' => ''
          ]);

          $ShoppingCart = ShoppingCart::where( 'member_id',auth('Member')->id() )
                                      ->where('product_id',$request->product_id)->first();

          $product = Product::findOrFail($request->product_id);

          //----------if in card -----------
          if($ShoppingCart)
          {
              $ShoppingCart->update([
                  'package' => $request->package,
              ]);

              return response()->json([
                'status' => 'success',
                'case' => 'modified',
                'data' => $ShoppingCart,
                'notifcation_msg' => __('page.adjusted')
              ]);
          }
          else // -----if not in card -----
          {
              $ShoppingCart = ShoppingCart::create([
                  'member_id' => auth('Member')->id(),
                  'product_id' => $request->product_id,
                  'package' => $request->package,
              ]);

              return response()->json([
                  'status' => 'success',
                  'case' => 'added',
                  'data' => $ShoppingCart,
                  'notifcation_msg' => __('page.Added to cart')
              ]);
          }
    }

    /*
     * POST
     * update_shopping_cart_item
     * update => ( brief_text , marketing_brief_id )
     */
    public function update_shopping_cart_item(Request $request)
    {

          $validator = \Validator::make($request->all(), [
            'id' => 'required',
            // 'brief_text' => 'required',
            // 'marketing_brief_id' => 'required',
          ]);
          if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

          $ShoppingCart = ShoppingCart::where( 'member_id',auth('Member')->id() )
                                      ->where('id',$request->id)->first();
          $updata_data = [];

          if($request->brief_text){
              $updata_data['brief_text'] = $request->brief_text;
          }
          if($request->marketing_brief_id){
              $updata_data['marketing_brief_id'] = $request->marketing_brief_id;
          }

          $ShoppingCart->update($updata_data);

          return response()->json([
            'status' => 'success',
            'case' => 'modified',
            'data' => $ShoppingCart,
            'notifcation_msg' => __('page.adjusted')
          ]);
    }

      public function remove($id)
      {
           ShoppingCart::where( 'member_id',auth('Member')->id() )->where('product_id',$id)->delete();
           return response()->json([
             'status' => 'success',
           ]);
      }

      public function get_Count_number()
      {
          return ShoppingCart::where( 'member_id',auth('Member')->id() )->count();
      }

}
