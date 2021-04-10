<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\ProductImages;

class HistoryController extends Controller
{

    public function __construct()
    {
       $this->middleware('auth:Member');
    }

      public function index()
      {
          return view('Site.History.History_list' );
      }

      public function list(Request $request)
      {
          $status = $request->status;
          $selectedDate = $request->selectedDate;
          $lang = \App::getLocale();
          $AuthMember_id = ( auth('Member')->check() )? auth('Member')->id() : 0 ;
           return Order::select('*' ,\DB::raw("DATE(created_at) as created_att"))
                          ->where(function($q)use($status,$selectedDate){
                              if($status){
                                 $q->where('delivery_status',$status);
                              }
                              if($selectedDate){
                                 $q->where('created_at','>=', date('Y-m-d', strtotime('-3 month')) );
                              }
                          })
                          ->where('member_id',$AuthMember_id)
                          ->where(function($q){
                             $q->whereNull('is_init_for_card_payment')
                             ->orWhere('is_init_for_card_payment',0);
                          })
                          ->latest()->paginate();
      }

      public function get_order_products_list($Order_id)
      {
          $lang = \App::getLocale();
          $OrderDetails = OrderDetails::select('recipt_products.*',"recipt_products.product_name_$lang as product_name",
                                   \DB::raw("IF(products.id,products.id,'#') as id_or_hash"),
                                   "products.short_description_$lang as short_description",
                                   \DB::raw("CONCAT('".asset('images/ProductImages')."/',product_images.image) as image")
                                 )
                                 ->leftJoin('products','products.id','recipt_products.product_id')
                                 ->leftJoin('product_images','product_images.product_id','products.id')
                                 ->groupBy('recipt_products.id')
                                 ->where('recipt_id',$Order_id)
                                 ->limit(500)->get();
            return $OrderDetails;
      }

      public function show($id)
      {
         $lang = \App::getLocale();
         $Order = Order::where('member_id',auth('Member')->id() )->findOrFail($id);  // return $Order;
         $OrderDetails = OrderDetails::select(
                           'order_details.id',
                           'order_details.order_id',
                           'order_details.item_type',
                           'order_details.delivery_status',
                           'order_details.price',
                           'order_details.member_brief',
                           'order_details.package_type',
                           'order_details.marketing_brief_id',
                           "order_details.product_name_$lang as product_name",
                           // "base_products.name_$lang as base_product_name",
                          "product_images.image",
                          "categories.name_$lang as category_name",
                          \DB::raw("CONCAT('".asset('category')."/',categories.id,'-',REPLACE(categories.name_$lang,' ','-')) as category_link"),
                          \DB::raw("IF(products.id,
                              CONCAT('".asset('product')."/',products.id,'-',REPLACE(products.name_$lang,' ','-')) ,
                              '#')
                            as product_link")
                      )
                      ->leftJoin('products','products.id','order_details.product_id')
                      ->leftJoin('product_images','product_images.product_id','products.id')
                      // ->leftJoin('base_products','base_products.id','products.base_product_id')
                      ->leftJoin('categories','categories.id','products.category_id')
                      ->groupBy('order_details.id')
                      ->where('order_id',$id)
                      ->get();
                                // return $OrderDetails;
         return view('Site.History.History_details',compact('Order','OrderDetails') );
      }

      public function cancle_order($Order_id)
      {
          $Order = Order::where('member_id',auth('Member')->id())->findOrFail($Order_id);
          $Order->update([ 'delivery_status' => 'canceled' ]);
          // increse in the stock
          $OrderDetails = OrderDetails::where('recipt_id',$Order->id)->get();
          foreach ($OrderDetails as $key => $RProduct)
          {
              $p = \App\Product::find($RProduct->product_id);
              if($p){
                  $p->increment('quantity');
              }
          }

          $member = \App\Member::find($Order->member_id);

          try {
            \Mail::to($member->email, 'Orders@superdelionline.com')
                  ->send(new \App\Mail\CancleOrder($Order,$member));
          } catch (\Exception $e) {

          }

          \Session::flash('flash_message','order has been cancled');
          return redirect('/History');
      }

      //--api---
      // public function cancle_order($Order_id)
      // {
      //     $Order = Order::where('member_id',auth('Member')->id())->findOrFail($Order_id);
      //     // increse in the stock
      //     $OrderDetails = OrderDetails::where('recipt_id',$Order->id)->get();
      //     foreach ($OrderDetails as $key => $RProduct)
      //     {
      //         $p = \App\Product::find($RProduct->product_id);
      //         if($p){
      //             $p->increment('quantity');
      //         }
      //     }
      //     $Order->update(['delivery_status' => 'canceled' ]);
      //
      // }


}
