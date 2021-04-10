<?php

namespace App\Http\Controllers\AdminApi;

use Illuminate\Http\Request;
use App\Http\Controllers\vueAdminController;
use App\Admin;

class AdminController extends vueAdminController
{

      public function __construct(Request $request)
      {
         parent::__construct();
         $this->set_model_name('Admin');

         $this->vars_for_selections =  [
            'roles' => \App\Role ::select('id as value','name as label')->get()
         ];

      }//End __construct

      public function get_list(Request $request)
      {
             $search = $request->search;

             $data = Admin::select( 'admins.id','admins.phone','admins.email','admins.username','admins.name','admins.role_id','super_admin',
                                    'roles.name as role'  )
             ->where(function($q)use($search){
                  if ($search)
                     $q->where('admins.name','LIKE','%'.$search.'%')->orWhere('phone','LIKE','%'.$search.'%')->orWhere('email','LIKE','%'.$search.'%')
                       ->orWhere('username','LIKE','%'.$search.'%')->orWhere('admins.id',$search);
               })
               ->leftJoin('roles','roles.id','admins.role_id')
               ->groupBy('admins.id')
               ->orderBy('admins.id')->paginate();
             return collect(['status' => 'success'])->merge($data);
      }


     public function store(Request $request)
     {
         $validator = \Validator::make($request->all(),[
             'name' => 'required',
             'username' => 'required|unique:admins',
             'password' => 'required',
             'email' => 'required',
             'phone' => 'required',
             'role_id' => 'required',
         ]);

        if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

          $admin = Admin::create([
               'name' => $request->name,
               'username' => $request->username ,
               'password' =>  \Hash::make($request->password),
               'email' => $request->email,
               'phone' => $request->phone,
               'role_id' => $request->role_id,
          ]);

          return response()->json([
            'status' => 'success',
            'data' => $admin
          ]);
     }

      public function update(Request $request)
      {
          $validator = \Validator::make($request->all(),[
               'id' => 'required',
               'name' => 'required',
               'username' => 'required|unique:admins,id,'.$request->id ,
               'password' => '',
               'email' => 'required',
               'phone' => 'required',
               'role_id' => 'required',
          ]);

          if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

          $item = Admin::findOrFail($request->id);
          $the_data = [
               'id' => $request->id,
               'name' => $request->name,
               'username' => $request->username ,
               'email' => $request->email,
               'phone' => $request->phone,
               'role_id' => $request->role_id,
          ];

          if($request->password)
            $the_data['password'] = \Hash::make($request->password);

          $item->update($the_data);

          return response()->json([
           'status' => 'success',
           'data' => $item
          ]);
      }

}
