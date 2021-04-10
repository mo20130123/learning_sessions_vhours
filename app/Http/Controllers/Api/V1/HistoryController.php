<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Recipt;
use App\ReciptProducts;
use App\ProductImages;

class HistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('MemberRequiredJWTAndLang') ;
    }

    public function list(Request $request)
    {
        $AuthMember_id = $request->MemberID;
        $selecteOrders = $request->selecteOrders;

         $Recipt = Recipt::select('id','final_price','delivery_status','created_at')
                        ->where('member_id',$AuthMember_id)->orderBy('id','desc')
                        ->where(function($q)use($selecteOrders){
                            if($selecteOrders)
                            {
                               switch ($selecteOrders)
                               {
                                 case 'current_orders':
                                     $q->where('delivery_status','Acknowledged')
                                       ->orWhere('delivery_status','Preparing')->orWhere('delivery_status','Dispatched');
                                   break;
                                 case 'past_orders':
                                     $q->where('delivery_status','Delivered')->orWhere('delivery_status','canceled');
                                   break;
                               }
                            }
                        })
                        ->whereNull('is_init_for_card_payment')
                        ->latest()->paginate();

         return collect(['status' => 'success'])->merge($Recipt);
    }

    public function show(Request $request,$id)
    {
       $lang = $request->lang;
       $AuthMember_id = $request->MemberID;

       $Recipt = Recipt::select('id','city','district','address','street','building_no','apartment_no',
                                'total_price','discount_percentage','final_price','delivery_status','payment_method','created_at')
                       ->where('member_id',$AuthMember_id )->findOrFail($id);  //return $Recipt;
       $ReciptProducts = ReciptProducts::select(
                                   \DB::raw("IF(products.id,products.id,'#') as id"),
                                   "recipt_products.product_name_$lang as name",'is_bundle',
                                  'recipt_products.single_price','recipt_products.single_price',
                                  'recipt_products.bundle_products_ids',
                                  "products.short_description_$lang as short_description",
                                "products.short_description_$lang as short_description",
                                \DB::raw("CONCAT('".asset('images/ProductImages')."/',product_images.image) as image")
                              )
                              ->leftJoin('products','products.id','recipt_products.product_id')
                              ->leftJoin('product_images','product_images.product_id','products.id')
                              ->groupBy('recipt_products.id')
                              ->where('recipt_id',$id)
                              ->paginate(30);

        foreach ($ReciptProducts as $item)
        {
            if($item->is_bundle)
            {
              $ProductImage = ProductImages::select('image')->whereIn('product_id', explode(',', $item->bundle_products_ids) )
                                             ->where('is_main',1)->first();
              $item->image = $ProductImage ? $ProductImage->image: '';
              unset($item->bundle_products_ids);
            }
        }

        return response()->json([
            'status' => 'success',
            'order' => $Recipt ,
            'Products' => $ReciptProducts ,
        ]);
    }

    public function cancle_order(Request $request)
    {
      $validator = \Validator::make($request->all(), [
            'order_id' => 'required',
      ]);
      if ($validator->fails()) {
          return response()->json([ 'status' => 'notValid' ,'status_message' => __('api.notValid') , 'missing_data' => $validator->messages() ]);
      }

        $AuthMember_id = $request->MemberID;
        $Recipt = Recipt::where('member_id',$AuthMember_id)->findOrFail($request->order_id);
        if( !($Recipt->delivery_status == 'Acknowledged' || $Recipt->delivery_status == 'Preparing') )
        {
          return response()->json([
              'status' => 'failed',
              'status_message' => __('api.you cant cancle now')
          ]);
        }
        $Recipt->update([ 'delivery_status' => 'canceled' ]);
        // increse in the stock
        $ReciptProducts = ReciptProducts::where('recipt_id',$Recipt->id)->get();
        foreach ($ReciptProducts as $key => $RProduct)
        {
            $p = \App\Product::find($RProduct->product_id);
            if($p){
                $p->increment('quantity');
            }
        }
        return response()->json([
            'status' => 'success',
            'status_message' => __('api.the order has been canceled')
        ]);
    }

}
