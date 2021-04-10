<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SavedBasket;
use App\SavedBasketItem;
use App\ShoppingCart;

class SavedBasketsController extends Controller
{

  public function __construct()
  {
      $this->middleware('auth:Member') ;
  }

    public function index()
    {
        $lang = \App::getLocale();
        $SavedBasket = SavedBasket::where('member_id', auth('Member')->id() )->latest()->get();

        return view('Site.saved_basket',compact('SavedBasket'));
    }

    public function show($id)
    {
        $lang = \App::getLocale();
        $SavedBasket = SavedBasket::where('member_id', auth('Member')->id() )->findOrFail($id);
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
        return view('Site.SavedBasket_details',compact('lang','SavedBasket','SavedBasketItem'));
    }

    public function delete_savedBasket($id)
    {
        $lang = \App::getLocale();
        $SavedBasket = SavedBasket::where('member_id', auth('Member')->id() )->where('id',$id)->delete();
        return response()->json([
           'status' => 'success',
       ]);
    }

    public function delete_item_from_savedBasket(Request $request)
    {
        $lang = \App::getLocale();
        $SavedBasket = SavedBasket::where('member_id', auth('Member')->id() )->where('id',$request->SavedBasket_id)->first();
          SavedBasketItem::where('saved_basket_id', $SavedBasket->id )->where('id',$request->item_id)->delete();
        return response()->json([
           'status' => 'success',
       ]);
    }

    public function load_savedBasket_ajax($id)
    {
        $lang = \App::getLocale();
        $SavedBasket = SavedBasket::where('member_id', auth('Member')->id() )->find($id);
        $SavedBasketItem = SavedBasketItem::select('product_id','quantity','cheese_type','cheese_weight',
                      \DB::raw("'".auth('Member')->id()."' as member_id"))
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
                   'member_id' => auth('Member')->id(),
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

    public function load_savedBasket_php($id)
    {
        $lang = \App::getLocale();
        $SavedBasket = SavedBasket::where('member_id', auth('Member')->id() )->find($id);
        $SavedBasketItem = SavedBasketItem::select('product_id','quantity','cheese_type','cheese_weight' )
                           ->where('saved_basket_id',$SavedBasket->id)->get() ;
         foreach ($SavedBasketItem as $key => $Item)
        {
             $check = ShoppingCart::where('member_id',$SavedBasket->member_id)
                                  ->where('product_id',$Item->product_id)
                                  ->first();
             if($check)
             {
                $check->increment('quantity',1);
             }
             else {
                 ShoppingCart::create([
                   'member_id' => $SavedBasket->member_id,
                   'product_id' => $Item->product_id ,
                   'quantity' => 1 ,
                   'cheese_type' => $Item->cheese_type ,
                   'cheese_weight' => $Item->cheese_weight ,
                 ]);
             }
         }

        \Session::flash('flash_message', __('page.items has been loaded into the cart') );
        return redirect('ShoppingCart');
    }

}
