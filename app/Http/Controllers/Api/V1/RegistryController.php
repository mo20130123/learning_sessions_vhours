<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

use App\Member;
use App\MemberAddress;
use App\ShoppingCart;


class RegistryController extends Controller
{
    public function __construct()
    {
        $this->middleware('ApiLang') ;
    }

   public function login(Request $request)
   {
      $validator = \Validator::make($request->all(), [
             'email' => 'required|max:224',
             'password' => 'required|max:224',
             'os' => 'required|in:android,ios',
             'app_version' => 'required',
             'model' => '',
             'firebase_token' => 'required',
       ]);
       if ($validator->fails()) {
          return response()->json([ 'status' => 'notValid' ,'status_message' => __('api.notValid') , 'missing_data' => $validator->messages() ]);
       }

       $Member = Member::where('email',$request->email)->where('password', md5('moi'.$request->password) )->first();
       if(!$Member)
       {
           return response()->json([
             'status' => 'failed',
             'status_message' => __('api.login_failed') ,
           ]);
       }

       $Member->update([
          'os' => $request->os,
          'app_version' => $request->app_version,
          'model' => $request->model,
          'firebase_token' => $request->firebase_token,
          'jwt' => Str::random(52)
       ]);

       $this->cut_Guest_Cart_to_Auth_cart($request->Guest_Cart,$Member->id);

       return response()->json([
           'status' => 'success',
           'status_message' => __('api.login_success') ,
           'jwt' => $Member->jwt,
       ]);
   }

   public function register(Request $request)
   {
      $validator = \Validator::make($request->all(), [
             'name' => 'required|max:224',
             'phone' => 'required|max:224',
             'email' => 'required|max:224|unique:members',
             'password' => 'required|max:224',
             'address' => 'required|max:224',
             'street' => 'required|max:224',
             'building_no' => 'required|max:224',
             'apartment_no' => 'required|max:224',
             'city_id' => 'required|max:224',
             'district_id' => 'required|max:224',

             'os' => 'required|in:android,ios',
             'app_version' => 'required',
             'model' => '',
             'firebase_token' => 'required',
       ]);
       if ($validator->fails())
        {
            if( $validator->errors()->has('email') && ($validator->errors()->count() == 1) )
                 return response()->json([ 'status' => 'notValid' , 'status_message' => __('api.The email has already been taken.') , 'missing_data' => (object)[] ]);
            else
                return response()->json([ 'status' => 'notValid' ,'status_message' => __('api.notValid') , 'missing_data' => $validator->messages() ]);
        }

       $Member = Member::create([
           'name' => $request->name,
           'email' => $request->email,
           'password' =>  md5('moi'.$request->password) ,
           'phone' => $request->phone,
           'os' => $request->os,
           'app_version' => $request->app_version,
           'model' => $request->model,
           'firebase_token' => $request->firebase_token,
           'jwt' => Str::random(52)
       ]);
       MemberAddress::create([
           'member_id' => $Member->id ,
           'address' => self::remove_quotes($request->address) ,
           'street' => self::remove_quotes($request->street) ,
           'building_no' => self::remove_quotes($request->building_no) ,
           'apartment_no' => self::remove_quotes($request->apartment_no) ,
           'city_id' => $request->city_id ,
           'district_id' => $request->district_id ,
       ]);

       $this->cut_Guest_Cart_to_Auth_cart($request->Guest_Cart,$Member->id);
       
       return response()->json([
           'status' => 'success',
           'status_message' => __('api.login_success') ,
           'jwt' => $Member->jwt,
       ]);
   }

   public function send_forget_password_email(Request $request)
   {
        $validator = \Validator::make($request->all(), [
              'email' => 'required|max:224',
        ]);
        if ($validator->fails()) {
           return response()->json([ 'status' => 'notValid' ,'status_message' => __('api.notValid') , 'missing_data' => $validator->messages() ]);
        }

         $Member = Member::where('email',$request->email)->first();
         if($Member)
         {
            $Member->update(['forget_password' => Str::random(80) ]);
            \Mail::to($Member->email)->send(new \App\Mail\ForgetPassword($Member));
         }

         return response()->json([
             'status' => 'success',
             'status_message' => __('api.email sent if right email') ,
         ]);
   }

   public function check_email_if_taken(Request $request)
   {
      $validator = \Validator::make($request->all(), [
          'email' => 'required|max:224|unique:members',
      ]);
      if ($validator->fails())
       {
           if( $validator->errors()->has('email') && ($validator->errors()->count() == 1) )
                return response()->json([ 'status' => 'emailTaken' , 'status_message' => __('api.The email has already been taken.')  ]);
           else
               return response()->json([ 'status' => 'notValid' ,'status_message' => __('api.notValid') , 'missing_data' => $validator->messages() ]);
       }

       return response()->json([
           'status' => 'success',
       ]);
   }


   public function cut_Guest_Cart_to_Auth_cart($Guest_Cart,$member_id)
   {
       if($Guest_Cart)
       {
           foreach ($Guest_Cart as $Guest_Cart_item)
           {
              $find = ShoppingCart::where('member_id', $member_id )->where('product_id', $Guest_Cart_item['id'] )
                                  ->first();
               if($find)
               {
                  $find->update([
                    'quantity' => $Guest_Cart_item['in_card_quantity'] ,
                    'cheese_type' => $Guest_Cart_item['cheese_type']??null ,
                    'cheese_weight' => $Guest_Cart_item['cheese_weight']??null ,
                  ]);
               }
               else
               {
                   ShoppingCart::create([
                     'member_id' => $member_id,
                     'product_id' => $Guest_Cart_item['id'] ,
                     'quantity' => $Guest_Cart_item['in_card_quantity'] ,
                     'cheese_type' => $Guest_Cart_item['cheese_type']??null ,
                     'cheese_weight' => $Guest_Cart_item['cheese_weight']??null ,
                   ]);
               }
           }//End foreach
       }//End if($Guest_Cart)
   }


   // public function resend_verification_code(Request $request)
   // {
   //     $validator = \Validator::make($request->all(), [
   //           'phone' => 'required|max:224',
   //     ]);
   //     if ($validator->fails()) {
   //        return response()->json([ 'status' => 'notValid' ,'status_message' => __('api.notValid') , 'missing_data' => $validator->messages() ]);
   //     }
   //
   //     return response()->json([
   //         'status' => 'success',
   //         'status_message' => __('api.resend_verification_code') ,
   //     ]);
   // }

}
