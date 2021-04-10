<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\PromoCodes;
use App\Models\MemberPromo;
use App\Models\MemberAddress;
use Carbon\Carbon;

class PromoCodesController extends Controller
{

      public function add_promo(Request $request)
      {
          $validator = \Validator::make($request->all(), [
              'code' => 'required',
              // 'choosen_Address' => 'required',
          ]);
          if ($validator->fails()) { return response()->json([ 'state' => 'notValid' , 'data' => $validator->messages() ]);  }

          $getPromoCodes = PromoCodes::where('code',$request->code)->where('status',1)->first();

          if(!$getPromoCodes)
          {
              \Session::flash('flash_message',__('page.wrong promo code'));
              return redirect('ShoppingCart/checkout');
          }
          else if( $getPromoCodes->from_date > Carbon::now() ){
             \Session::flash('flash_message',__('page.promo is futuristic'));
             return redirect('ShoppingCart/checkout');
          }
          else if( $getPromoCodes->to_date < Carbon::now() ){
             \Session::flash('flash_message',__('page.promo has expired'));
             return redirect('ShoppingCart/checkout');
          }
          else if( $getPromoCodes->allowed_number_of_usage <= $getPromoCodes->actual_number_of_usage ){
             \Session::flash('flash_message',__('page.last promo has been used'));
             return redirect('ShoppingCart/checkout');
          }

          $count_used_before = MemberPromo::where( 'member_id',auth('Member')->id() )->where('promo_id',$getPromoCodes->id)->count();

          if($count_used_before >= $getPromoCodes->allowed_number_per_user)
          {                          
              \Session::flash('flash_message',__('page.you are not allowed to use this code anymore'));
              return redirect('ShoppingCart/checkout');
          }

          MemberPromo::where( 'member_id',auth('Member')->id() )->whereNull('used_date')->delete();

         MemberPromo::create([
            'member_id' => auth('Member')->id() ,
            'promo_id' => $getPromoCodes->id,
         ]);
         $getPromoCodes->increment('actual_number_of_usage');
         \Session::flash('flash_message',__('page.Promo code has been added'));
         return redirect('ShoppingCart/checkout');
      }

      // public function get_code_percentage_value($code)
      // {
      //     $promo = PromoCodes::where('code',$code)->where('status',1)
      //        ->where(function ($q) {
      //             $q->where('from_date', '<=', Carbon::now());
      //             $q->where('to_date', '>=', Carbon::now());
      //        })->first();
      //
      //        $chek_if_used_before = MemberPromo::where( 'member_id',auth('Member')->id() )->where('promo_id',$promo->id)->first();
      //
      //        if($chek_if_used_before)
      //        {
      //            return response()->json([
      //              'status' => 'added_before',
      //            ]);
      //        }
      //
      //        if($promo)
      //        {
      //            return response()->json([
      //              'status' => 'success',
      //              'data' => $promo,
      //            ]);
      //        }
      //        else {
      //            return response()->json([
      //              'status' => 'failed',
      //            ]);
      //        }
      // }
      //

}
