<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Recipt;
use App\City;
use App\ReciptProducts;
use App\Product;

class ReciptController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index()
    {
        $cities = \App\City::select('name_en as label','id as value')->get(); //return $cities;
        return view('Admin.Recipt.index',compact('cities'));
    }

    //---api----
    public function get_list(Request $request)
    {
         $search = $request->search;
         $city_id = $request->city_id;
         $status = $request->status;
         $data_from = $request->data_from;
         $data_to = $request->data_to;
         return Recipt::select('recipts.*','members.name as member_name','members.email as member_email','members.phone as member_phone',
                 'members.id as member_id' )
          ->where(function($q)use($search,$city_id,$status){
              if($city_id){
                $q->where('members.city_id',$city_id);
              }
              if($status){
                  if($status == 'processing'){
                      $q->where('recipts.delivery_status','processing');
                  }
                  else if($status == 'shipping'){
                      $q->where('recipts.delivery_status','shipping');
                  }
                  else if($status == 'delivered'){
                      $q->where('recipts.delivery_status','delivered');
                  }
                  else if($status == 'canceled'){
                      $q->where('recipts.delivery_status','canceled');
                  }
                  else if($status == 'paid'){
                      $q->where('recipts.is_piad',1);
                  }
              }
              if ($search)
                $q->where('members.name','like','%'.$search.'%')->orWhere('members.email','like','%'.$search.'%')
                  ->orWhere('members.phone',$search)
                  ->orWhere('recipts.id',$search);
          })
          ->where(function($q)use($data_from,$data_to){
             if($data_from && $data_to){
                // $q->where('recipts.created_at','>=',$data_from)->where('recipts.created_at','<=',$data_to);
                $q->whereBetween('recipts.created_at',[$data_from,$data_to]) ;
             }
             else if($data_from){
                $q->where('recipts.created_at','>=',$data_from) ;
             }
             else if($data_to){
                $q->where('recipts.created_at','<=',$data_to);
             }
          })
          ->whereNull('is_init_for_card_payment')
          ->leftJoin('members','members.id','recipts.member_id')
          // ->leftJoin('cities','cities.id','members.city_id')
          ->groupBy('recipts.id')
          ->latest('id')->paginate();
    }


    public function show($recipt_id)
    {
         $Recipt = Recipt::select('recipts.*','members.name as member_name','members.email as member_email','members.phone as member_phone',
                 'recipts.address as member_address', 'street','building_no','apartment_no',
                 'members.id as member_id' ,'free_test_id')
         ->leftJoin('members','members.id','recipts.member_id')
         // ->leftJoin('cities','cities.id','members.city_id')
         ->groupBy('recipts.id')
         ->where('recipts.id',$recipt_id)
         ->first();  //free_test_id

         $Products = ReciptProducts::where('recipt_id',$recipt_id)->get();
         $FreeTest = \App\FreeTestList::find($Recipt->free_test_id);

         return view('Admin.Recipt.invoice',compact('Recipt','Products','FreeTest'));
    }

    public function print_show($recipt_id)
    {
         $Recipt = Recipt::select('recipts.*','members.name as member_name','members.email as member_email','members.phone as member_phone',
                 'recipts.address as member_address', 'street','building_no','apartment_no',
                 'members.id as member_id','free_test_id')
         ->leftJoin('members','members.id','recipts.member_id')
         // ->leftJoin('cities','cities.id','members.city_id')
         ->groupBy('recipts.id')
         ->where('recipts.id',$recipt_id)
         ->first();  //free_test_id

         $Products = ReciptProducts::where('recipt_id',$recipt_id)->get();

         $FreeTest = \App\FreeTestList::find($Recipt->free_test_id);

         return view('Admin.Recipt.print',compact('Recipt','Products','FreeTest'));
    }

    //--api--
    public function changeDeliveryStatus($id,$status)
    {
         $Recipt = Recipt::findOrFail($id);  

         //--- if the order canceled -> decrease quantity in the stock
         if($status=='canceled' && $Recipt->delivery_status != 'canceled'){
              // decrement in the stock
              $ReciptProducts = ReciptProducts::where('recipt_id',$Recipt->id)->get();
              foreach ($ReciptProducts as $key => $RProduct)
              {
                  $p = Product::find($RProduct->product_id);
                  if($p){
                    if($p->quantity > 0)
                      $p->decrement('quantity');
                  }
              }
         }
         //--- else if the order turned from canceled to any case -> increase quantity in the stock
         else if ($status!='canceled' && $Recipt->delivery_status == 'canceled')
         {
              // increse in the stock
              $ReciptProducts = ReciptProducts::where('recipt_id',$Recipt->id)->get();
              foreach ($ReciptProducts as $key => $RProduct)
              {
                  $p = Product::find($RProduct->product_id);
                  if($p){
                      $p->increment('quantity');
                  }
              }
         }
         $Recipt->update(['delivery_status' => $status ]);
         if( $Recipt->delivery_status == 'delivered' )
         {
            $member = \App\Member::find($Recipt->member_id);
            if($member){
                // \Mail::to( $member->email )
                //      ->send(new \App\Mail\ReciptDelivered($Recipt,$member));
                $member->update([
                   'should_rate_order_id' => $Recipt->id
                ]);
            }
         }

         return response()->json([
             'status' => 'success',
             'case' => $status
         ]);
    }

    //--api--
    public function switchPiad($id)
    {
         $item = Recipt::findOrFail($id);
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
           $deleted = Recipt::destroy($id);
         } catch (\Exception $e) {
           return 'false';
         }
         return 'true';
    }

    public function add_serial_to_recipt(Request $request)
    {
        $item = Recipt::findOrFail($request->recite_id);
        $item->update(['serial_no' => $request->serial_no]);

        return back();
    }

}
