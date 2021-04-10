<?php
namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\SavedBasket;
use App\SavedBasketItem;
use App\ShoppingCart;

class SavedBasketsController extends Controller
{

    public function __construct()
    {
        $this->middleware('MemberRequiredJWTAndLang') ;
    }

    public function save_basket(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'basket_name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'notValid', 'status_message' => __('api.notValid'), 'missing_data' => $validator->messages()]);
        }

        $ShoppingCart = ShoppingCart::where('member_id', $request->MemberID)->where('is_bundle', 0)
        ->leftJoin('products', 'shopping_cart.product_id', 'products.id')
        ->groupBy('shopping_cart.id')
        ->get();

        if($ShoppingCart->isEmpty()){
            return response()->json([
                'status' => 'failed',
                'status_message' => 'empty card'
            ]);
        }

        $SavedBasket = SavedBasket::create([
            'member_id' => $request->MemberID,
            'name' => $request->basket_name
        ]);

        foreach ($ShoppingCart as $Cart) {
            $Item = SavedBasketItem::create([
                'saved_basket_id' => $SavedBasket->id,
                'product_id' => $Cart->product_id,
                'quantity' => $Cart->quantity,
                'cheese_type' => $Cart->cheese_type,
                'cheese_weight' => $Cart->cheese_weight,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'status_message' => __('page.basket has been saved')
        ]);
    }

    public function index(Request $request)
    {
        $SavedBaskets = SavedBasket::select('id', 'name', 'created_at')
                            ->where('member_id', $request->MemberID )->latest()->get();

        return response()->json([
            'status' => 'success',
            'SavedBaskets' => $SavedBaskets
        ]);
    }

    public function show(Request $request,$id)
    {
        $lang = $request->lang;
        $SavedBasket = SavedBasket::select('id', 'name', 'created_at')
                                  ->where('member_id', $request->MemberID )->findOrFail($id);
        $SavedBasketItem = SavedBasketItem::select( 'saved_basket_items.id as saved_basket_item_id',
                                  'saved_basket_items.quantity','cheese_type','cheese_weight',
                                  "products.name_$lang as product_name",'products.price as product_price',
                                  "short_description_$lang as short_description" ,
                                   \DB::raw("GROUP_CONCAT(CONCAT('".asset('images/ProductImages')."/',product_images.image)) as image")
                           )
                           ->join('products','products.id','saved_basket_items.product_id','SavedBasketItem')
                           ->leftJoin('product_images',function($q){
                               $q->on('product_images.product_id','products.id')->where('product_images.is_main',1);
                           })
                           ->groupBy('saved_basket_items.id')
                           ->where('saved_basket_id',$id)
                           ->where('products.status',1)->get() ;

        return response()->json([
            'status' => 'success',
            'SavedBasket' => $SavedBasket,
            'SavedBasketItem' => $SavedBasketItem
        ]);
    }

    public function delete_savedBasket(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'SavedBasket_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'notValid', 'status_message' => __('api.notValid'), 'missing_data' => $validator->messages()]);
        }
        $lang = \App::getLocale();
        $SavedBasket = SavedBasket::where('member_id', $request->MemberID )->where('id', $request->SavedBasket_id)->delete();
        return response()->json([
           'status' => 'success',
       ]);
    }

    public function delete_item_from_savedBasket(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'SavedBasket_id' => 'required',
            'item_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'notValid', 'status_message' => __('api.notValid'), 'missing_data' => $validator->messages()]);
        }
        $lang = \App::getLocale();
        $SavedBasket = SavedBasket::where('member_id', $request->MemberID )->where('id',$request->SavedBasket_id)->first();
        if(!$SavedBasket){
            return response()->json([
                'status' => 'failed',
            ]);
        }
         SavedBasketItem::where('saved_basket_id', $SavedBasket->id )->where('id', $request->item_id)->delete();
        return response()->json([
           'status' => 'success',
        ]);
    }

    public function load_savedBasket(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'SavedBasket_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'notValid', 'status_message' => __('api.notValid'), 'missing_data' => $validator->messages()]);
        }

        $SavedBasket = SavedBasket::where('member_id', $request->MemberID )->find($request->SavedBasket_id);
        if (!$SavedBasket) {
            return response()->json([
                'status' => 'failed',
            ]);
        }
        $SavedBasketItem = SavedBasketItem::select('product_id','quantity','cheese_type','cheese_weight',
                      \DB::raw("'". $request->MemberID ."' as member_id"))
                           ->where('saved_basket_id',$SavedBasket->id)->get() ;

        foreach ($SavedBasketItem as $key => $Item)
        {
             $check = ShoppingCart::where('member_id',$Item->member_id)
                                  ->where('product_id',$Item->product_id)
                                  ->first();
             if($check)
             {
                $check->increment('quantity');
             }
             else {
                 ShoppingCart::create([
                   'member_id' => $request->MemberID,
                   'product_id' => $Item->product_id ,
                   'quantity' => $Item->quantity ,
                   'cheese_type' => $Item->cheese_type ,
                   'cheese_weight' => $Item->cheese_weight ,
                 ]);
             }
         }

        // ShoppingCart::insert($SavedBasketItem);

        return response()->json([
           'status' => 'success',
       ]);
    }


}
