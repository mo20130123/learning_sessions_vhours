<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Member;
use App\MemberAddress;

class ProfieController extends Controller
{
    public function __construct()
    {
        $this->middleware('MemberRequiredJWTAndLang') ;
    }

   public function get_address_list(Request $request)
   {
       $Address = MemberAddress::select('id','city_id','district_id','address','street','building_no','apartment_no')
                               ->where('member_id',$request->Member->id)->get();

       return response()->json([
           'status' => 'success',
           'data' => $Address ,
       ]);
   }

   public function add_new_address(Request $request)
   {
       $validator = \Validator::make($request->all(), [
            'address' => 'required|max:224',
            'street' => 'required|max:224',
            'building_no' => 'required|max:224',
            'apartment_no' => 'required|max:224',
            'city_id' => 'required|numeric',
            'district_id' => 'required|numeric',
       ]);
       if ($validator->fails()) {
           return response()->json([ 'status' => 'notValid' ,'status_message' => __('api.notValid') , 'missing_data' => $validator->messages() ]);
       }

       $Address = MemberAddress::create([
           'member_id' => $request->Member->id ,
           'address' => self::remove_quotes($request->address) ,
           'street' => self::remove_quotes($request->street) ,
           'building_no' => self::remove_quotes($request->building_no) ,
           'apartment_no' => self::remove_quotes($request->apartment_no) ,
           'city_id' => $request->city_id ,
           'district_id' => $request->district_id ,
       ]);

       return response()->json([
           'status' => 'success',
           'status_message' => __('api.new adderess has been added')
       ]);
   }

   public function update_profile(Request $request)
   {
       $validator = \Validator::make($request->all(), [
            'name' => 'required|max:224',
            'email' => 'required|unique:members,email,'.$request->Member->id,
            'phone' => 'required|max:224',
       ]);
       if ($validator->fails())
       {
          if( $validator->errors()->has('email') && ($validator->errors()->count() == 1) )
               return response()->json([ 'status' => 'notValid' , 'status_message' => __('api.The email has already been taken.') , 'missing_data' => (object)[] ]);
          else
              return response()->json([ 'status' => 'notValid' ,'status_message' => __('api.notValid') , 'missing_data' => $validator->messages() ]);
       }

       $request->Member->update([
         'name' => $request->name ,
         'email' => $request->email ,
         'phone' => $request->phone ,
       ]);

       return response()->json([
           'status' => 'success',
           'status_message' => __('api.profile has been updated')
       ]);
   }

   public function get_profile(Request $request)
   {
       return response()->json([
           'status' => 'success',
           'data' => [
               'name' => $request->Member->name ,
               'email' => $request->Member->email ,
               'phone' => $request->Member->phone ,
           ]
       ]);
   }


   public function change_password(Request $request)
   {
       $validator = \Validator::make($request->all(), [
             'old_password' => 'required|max:224',
             'password' => 'required|max:224',
       ]);
       if ($validator->fails()) {
           return response()->json([ 'status' => 'notValid' ,'status_message' => __('api.notValid') , 'missing_data' => $validator->messages() ]);
       }

       $old_password = md5('moi'.$request->old_password);
       $new_password = md5('moi'.$request->password);
       if( $old_password == $request->Member->password )
       {
           $request->Member->update([
              'password' => $new_password
           ]);

           return response()->json([
               'status' => 'success',
               'status_message' => __('page.password has updated')
           ]);
       }
       else
       {
           return response()->json([
               'status' => 'failed',
               'status_message' => __('page.wrong old password')
           ]);
       }
    }


}
