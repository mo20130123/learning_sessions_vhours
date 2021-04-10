<?php

namespace App\Http\Controllers\AdminApi;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Country;
use App\Models\Member;

class MemberController extends Controller
{


    // public function __construct()
    // {
    //    $this->middleware('verifyAdminApiAuth')->except('Export');
    // }

    public function selection_data(Request $request)
    {
        $countries = Country::select('name_en as label','id as value')->get();

        return response()->json([
           'status' => 'success',
           'Countries' => $countries ,
        ]);
    }

    //---api----
    public function get_list(Request $request)
    { 
         $search = $request->search;
         $country_id = $request->country_id;
       	// 'choose_district' => 'choose_district'
         $Members = Member::select('members.*' ,'countries.name_en as country_name'  )
          ->where(function($q)use($search){
              if ($search)
                $q->where('name','like','%'.$search.'%')->orWhere('company','like','%'.$search.'%')
                  ->orWhere('title','like','%'.$search.'%')->orWhere('email','like','%'.$search.'%')
                  ->orWhere('phone','like','%'.$search.'%')
                  ->orWhere('members.id',$search);
          })
          ->where(function($q)use($country_id){
              if($country_id){
                $q->where('country_id',$country_id);
              }
          })
          ->leftJoin('countries','members.country_id','countries.id')
          ->groupBy('members.id')
          ->with('getMarketingBrief')
          ->latest('members.id')->paginate();

          return collect(['status' => 'success'])->merge($Members);
    }

    public function store(Request $request)
    {
      // return $request->all();
        $validator = \Validator::make($request->all(), [
          'country_id' => 'required',
          'wallet' => 'required',
          'name' => 'required',
          'company' => 'required',
          'password' => 'required',
          'title' => 'required',
          'company_size' => 'required',
          'email' => 'required|unique:members',
          'phone' => 'required',
        ]);
        if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

        $the_data = [
          'wallet' => $request->wallet,
          'country_id' => $request->country_id,
          'name' => $request->name,
          'company' => $request->company,
          'password' => md5('moi'.$request->password) ,
          'title' => $request->title,
          'company_size' => $request->company_size,
          'email' => $request->email,
          'phone' => $request->phone,
          'is_allowed' => ($request->is_allowed == 'true' || $request->is_allowed == 1),
        ];

      $Member = Member::create($the_data);


      return response()->json([
        'status' => 'success',
        'data' => $Member
      ]);
    }

    //--api--
    public function update(Request $request)
    {
        $validator = \Validator::make($request->all(), [
          'id' => 'required',
          'country_id' => 'required',
          'wallet' => 'required',
          'name' => 'required',
          'company' => 'required',
          'password' => '',
          'title' => 'required',
          'company_size' => 'required',
          'email' => 'required|unique:members,email,'.$request->id,
          'phone' => 'required',
        ]);
        if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

        $the_data = [
          'wallet' => $request->wallet,
          'country_id' => $request->country_id,
          'name' => $request->name,
          'company' => $request->company,
          'title' => $request->title,
          'company_size' => $request->company_size,
          'email' => $request->email,
          'phone' => $request->phone,
          'is_allowed' => ($request->is_allowed == 'true' || $request->is_allowed == 1),
        ];

        if($request->password){
           $the_data['password'] = md5('moi'.$request->password);
       }

        $Member = Member::findOrFail($request->id);

        $Member->update($the_data);

        return response()->json([
          'status' => 'success',
          'data' => $Member,
        ]);

    }


    //--api--
    public function destroy($id)
    {
         try {
           $deleted = Member::destroy($id);
         } catch (\Exception $e) {
           return 'false';
         }
         return 'true';
    }

     public function Export()
     {
       return  \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\MemberExport, 'Members.xlsx');
     }

}
