<?php

namespace App\Http\Controllers\AdminApi\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Str;

class LoginController extends Controller
{

      public function __construct()
      {
         $this->middleware('verifyAdminApiAuth')->only('check_admin_jwt');
      }

       public function admin_login(Request $request)
       {
              $validator = \Validator::make($request->all(), [
                 'username' => 'required',
                 'password' => 'required'
              ]);
              if ($validator->fails()) { return response()->json([ 'state' => 'notValid' , 'data' => $validator->messages() ]);  }

              $get_Admin = Admin::where('username', $request->username)->first();
              if($get_Admin)
              {
                 if( \Hash::check($request->password,$get_Admin->password) )
                 {
                    if(!$get_Admin->jwt)
                       $get_Admin->update([
                          'jwt' => Str::random(52)
                       ]);

                       $Permissions = ['is_super_admin'];
                       if(!$get_Admin->super_admin){
                         $Permissions = $get_Admin->get_Role->get_Permissions()->pluck('title');
                       }

                    return response()->json([
                        'status' => 'success',
                        'jwt' => $get_Admin->jwt,
                        'Permissions' => $Permissions,
                    ]);
                 }
              }

              return response()->json([
                  'status' => 'failed',
              ]);
       }

       public function check_admin_jwt(Request $request)
       {
          return response()->json([
             'status' => 'success'
          ]);
       }


}
