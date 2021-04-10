<?php

namespace App\Http\Controllers\AdminApi;

use Illuminate\Http\Request;
use App\Http\Controllers\vueAdminController;
use App\Permission;
use App\Role;

class RoleController extends vueAdminController
{


    public function __construct(Request $request)
    {
        parent::__construct();
        $this->set_model_name('Role');

        $this->search_attrs =  [
             'id' , 'name'
        ];


    }//End __construct

    public function get_list(Request $request)
    {
           $search = $request->search;

           $data = Role::select( 'roles.*', \DB::raw("GROUP_CONCAT(R_perm.permission_id) as permissions")  )
           ->where(function($q)use($search){
                if ($search)
                   $q->where('roles.name','LIKE','%'.$search.'%')->orWhere('roles.id',$search);
             })
             ->leftJoin('role_permission as R_perm','R_perm.role_id','roles.id')
             ->groupBy('roles.id')
             ->orderBy('roles.id')->paginate();
           return collect(['status' => 'success'])->merge($data);
    }


    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(),[
          'name' => 'required',
          'comment' => 'required',
          'permissions' => 'required'
        ]);
       if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

        $role = Role::create([
            'name' => $request->name ,
            'comment' => $request->comment ,
        ]);
        $role->get_Permissions()->attach(explode(',', $request->permissions));

        return response()->json([
          'status' => 'success',
          'data' => $role
        ]);
    }


    public function update(Request $request)
    {
         $validator = \Validator::make($request->all(),[
            'name' => 'required',
            'comment' => 'required',
            'permissions' => 'required'
         ]);
         if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

        $role = Role::findOrFail($request->id);
        $role->update([
            'name' => $request->name ,
            'comment' => $request->comment ,
        ]);

        $role->get_Permissions()->sync(explode(',', $request->permissions));

        // for logout the admins
        $Admins = \App\Admin::where('role_id',$request->id)->get();
        foreach ($Admins as $key => $Admin)
        {
           $Admin->update([
             'jwt' => \Str::random(52)
           ]);
        }

        return response()->json([
           'status' => 'success',
           'data' => $role
       ]);
    }

}
