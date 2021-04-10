<?php

namespace App\Http\Controllers\AdminApi;

use App\Models\OrderDetailsModifications;
use App\Models\WalletPaymets;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Models\Member;
use App\Models\City;
use App\Models\OrderDetails;
use App\Models\Product;

class OrderController extends Controller
{
    public function __construct()
    {
      $this->middleware('verifyAdminApiAuth');
    }

    public function index()
    {
        $cities = \App\City::select('name_en as label','id as value')->get(); //return $cities;
        return view('Admin.Order.index',compact('cities'));
    }

    //---api----
    public function get_list(Request $request)
    {

         $search = $request->search;
         $city_id = $request->city_id;
         $status = $request->status;
         $data_from = $request->data_from;
         $data_to = $request->data_to;
         return Order::select('orders.*','members.name as member_name','members.email as member_email',
                                         'members.phone as member_phone'

                            )
          ->where(function($q)use($search,$city_id,$status){
              if ($search)
                $q->where('members.name','like','%'.$search.'%')->orWhere('members.email','like','%'.$search.'%')
                  ->orWhere('members.phone',$search)->orWhere('orders.id',$search);
          })
          ->where(function($q)use($data_from,$data_to){
             if($data_from && $data_to){
                // $q->where('orders.created_at','>=',$data_from)->where('orders.created_at','<=',$data_to);
                $q->whereBetween('orders.created_at',[$data_from,$data_to]) ;
             }
             else if($data_from){
                $q->where('orders.created_at','>=',$data_from) ;
             }
             else if($data_to){
                $q->where('orders.created_at','<=',$data_to);
             }
          })
          ->where(function($q){
             $q->whereNull('is_init_for_card_payment')
               ->orWhere('is_init_for_card_payment',0);
          })
          ->leftJoin('members','members.id','orders.member_id')
          ->groupBy('orders.id')
          ->latest('orders.id')->paginate();
    }


    public function details($order_id)
    {
         $Order = Order::select('orders.*',
                 'members.name as member_name','members.email as member_email','members.phone as member_phone',
                 'members.id as member_id'  )
         ->leftJoin('members','members.id','orders.member_id')
         ->groupBy('orders.id')
         ->where('orders.id',$order_id)
         ->first();

         $Products = OrderDetails::select(
                           'order_details.id',
                           'order_details.order_id',
                           'order_details.item_type',
                           'order_details.delivery_status',
                           'order_details.price',
                           'order_details.member_brief',
                           'order_details.package_type',
                           'order_details.marketing_brief_id',
                           "order_details.product_name_en as product_name",
                           "order_details.product_id",
                           // "base_products.name_en as base_product_name",
                          "product_images.image",
                          "categories.name_en as category_name",
                          "providers.name_en as provider_name",
                        \DB::raw("0 as showModificationsList")
                      )
                      ->leftJoin('products','products.id','order_details.product_id')
                      ->leftJoin('providers','products.provider_id','providers.id')
                      ->leftJoin('product_images','product_images.product_id','products.id')
                      // ->leftJoin('base_products','base_products.id','products.base_product_id')
                      ->leftJoin('categories','categories.id','products.category_id')
                      ->groupBy('order_details.id')
                      ->where('order_id',$order_id)
                      ->with('getMarketingBrief')
                      ->with('getOrderDetailsAdminInfo')
                      ->with('getOrderModifications')

                      ->get();

         return response()->json([
           'status' => 'success',
           'Order' => $Order,
           'Products' => $Products,
         ]);
    }

    public function print_show($recipt_id)
    {
         $Order = Order::select('orders.*','members.name as member_name','members.email as member_email','members.phone as member_phone',
                 'orders.address as member_address', 'street','building_no','apartment_no',
                 'members.id as member_id','free_test_id')
         ->leftJoin('members','members.id','orders.member_id')
         // ->leftJoin('cities','cities.id','members.city_id')
         ->groupBy('orders.id')
         ->where('orders.id',$recipt_id)
         ->first();  //free_test_id

         $Products = OrderDetails::where('recipt_id',$recipt_id)->get();

         $FreeTest = \App\FreeTestList::find($Order->free_test_id);

         return view('Admin.Order.print',compact('Order','Products','FreeTest'));
    }

    //--api--
    public function changeDeliveryStatus(Request $request)
    {
          $validator = \Validator::make($request->all(),[
              'order_details_id' => 'required',
              'delivery_status' => 'required',
          ]);
         if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

         $OrderDetail = OrderDetails::findOrFail($request->order_details_id);
         $OrderDetail->update([
            'delivery_status' => $request->delivery_status
         ]);

         // update OrderDetailsAdminInfo date
         $OrderDetail->getOrderDetailsAdminInfo()->update([
            str_replace(' ', '',$request->delivery_status) . '_date' => \Carbon\Carbon::now()
         ]);

         if($OrderDetail->delivery_status == 'Delivered')
         {
            $order = Order::find($OrderDetail->order_id);
            $member = Member::find($order->member_id);
            if($member)
            {
                $wallet_increasment_amount = round($member->wallet + ($OrderDetail->price * 0.1)); // 10%
                $member->update([ 'wallet' => $wallet_increasment_amount ]);
                WalletPaymets::create([
                    'member_id' => $order->member_id,
                    'amount' => $wallet_increasment_amount,
                    'is_paid' => 1 ,
                    'source' => 'points'
                ]);
            }

         }

         return response()->json([
             'status' => 'success',
             'delivery_status' => $OrderDetail->delivery_status,
             'getOrderDetailsAdminInfo' => $OrderDetail->getOrderDetailsAdminInfo
         ]);
    }

    //--api--
    public function switchPiad($id)
    {
         $item = Order::findOrFail($id);
         if( $item->is_piad )
         {
            $item->update(['is_piad' => '0']);
            $case = 0;
         }
         else
         {
            $item->update(['is_piad' => '1']);
            $case = 1;
         }

         return response()->json([
             'status' => 'success',
             'case' => $case
         ]);
    }

    //--api--
    public function destroy($id)
    {
         try {
           $deleted = Order::destroy($id);
         } catch (\Exception $e) {
           return 'false';
         }
         return 'true';
    }

    public function add_serial_to_recipt(Request $request)
    {
        $item = Order::findOrFail($request->recite_id);
        $item->update(['serial_no' => $request->serial_no]);

        return back();
    }

    public function updateAdminComment_of_orderDetails(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'order_details_adminInfo_id' => 'required',
            'admin_comment' => 'required',
        ]);
        if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

        $item = OrderDetailsAdminInfo::findOrFail($request->order_details_adminInfo_id);
        $item->update(['admin_comment' => $request->admin_comment]);

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function Add_modification(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'order_details_id' => 'required',
            'name_en' => 'required',
            'name_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'price' => 'required',
        ]);
        if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

        $Modification = OrderDetailsModifications::create([
            'order_details_id' => $request->order_details_id ,
            'name_en' => $request->name_en ,
            'name_ar' => $request->name_ar ,
            'description_en' => $request->description_en ,
            'description_ar' => $request->description_ar ,
            'price' => $request->price ,
        ]);
        return response()->json([
            'status' => 'success',
            'Modification' => $Modification
        ]);
    }

}
