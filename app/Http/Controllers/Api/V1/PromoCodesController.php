<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\PromoCodes;
use App\MemberPromo;
use App\MemberAddress;
use Carbon\Carbon;

class PromoCodesController extends Controller
{
    public function __construct()
    {
        $this->middleware('MemberRequiredJWTAndLang') ;
    }


    public function add_promo(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'code' => 'required',
            'choosen_Address' => 'required',
        ]);
        if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

        $AuthMember_id = $request->MemberID;

        $getPromoCodes = PromoCodes::where('code',$request->code)->where('status',1)->first();

        if(!$getPromoCodes)
        {
            return response()->json([
              'status' => 'failed',
              'status_message' => __('page.wrong promo code')
            ]);
        }
        if($getPromoCodes->city_id)
        {
            $get_MemberAddress = MemberAddress::find($request->choosen_Address);
            if($get_MemberAddress->city_id != $getPromoCodes->city_id){
                return response()->json([
                  'status' => 'failed',
                  'status_message' => __('page.city not matched')
                ]);
            }
        }
        else if( $getPromoCodes->from_date > Carbon::now() ){
           return response()->json([
             'status' => 'failed',
             'status_message' => __('page.promo is futuristic')
           ]);
        }
        else if( $getPromoCodes->to_date < Carbon::now() ){
           return response()->json([
             'status' => 'failed',
             'status_message' => __('page.promo has expired')
           ]);
        }
        // else if( $getPromoCodes->allowed_number_of_usage <= $getPromoCodes->actual_number_of_usage ){
        //    \Session::flash('flash_message',__('page.last promo has been used'));
        //    return redirect('ShoppingCart');
        // }

        $chek_if_used_before = MemberPromo::where( 'member_id',$AuthMember_id )->where('promo_id',$getPromoCodes->id)->first();

        if($chek_if_used_before)
        {
            return response()->json([
              'status' => 'failed',
              'status_message' => __('page.you used this code before')
            ]);
        }

       MemberPromo::create([
          'member_id' => $AuthMember_id ,
          'promo_id' => $getPromoCodes->id,
          'city_id' => $request->choosen_Address
       ]);
       $getPromoCodes->increment('actual_number_of_usage');

       return response()->json([
         'status' => 'success',
         'status_message' =>  __('page.Promo code has been added'),
         'promo_discount_percentage' => $getPromoCodes->discount_percentage
       ]);
    }


}
