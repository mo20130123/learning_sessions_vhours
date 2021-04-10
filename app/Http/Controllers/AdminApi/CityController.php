<?php

namespace App\Http\Controllers\AdminApi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\City;

class CityController extends Controller
{
   public function __construct()
   {
     $this->middleware('verifyAdminApiAuth');
   }

    //---api----
    public function get_list(Request $request)
    {
         $search = $request->search;
         return City::
          where(function($q)use($search){
              if ($search)
                $q->where('name_en','like','%'.$search.'%')->orWhere('name_ar','like','%'.$search.'%')->orWhere('id',$search);
          })
          ->latest('id')->paginate();
    }

    public function store(Request $request)
    {
          $validator = \Validator::make($request->all(), [
              'name_en' => 'required',
              'name_ar' => 'required',
          ]);
          if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }
          $item = City::create($request->except('_token'));
          $item->status = 1;
          return response()->json([
            'status' => 'success',
            'data' => $item
          ]);
    }

    //--api--
    public function update(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'id' => 'required',
            'name_en' => 'required',
            'name_ar' => 'required',
        ]);
        if ($validator->fails()) { return response()->json([ 'state' => 'notValid' , 'data' => $validator->messages() ]);  }

        $item = City::findOrFail($request->id);
        $item->update($request->except('_token'));
        return response()->json([
          'status' => 'success',
          'data' => $item
        ]);
    }

    //--api--
    public function showORhide($id)
    {
         $item = City::findOrFail($id);
         if( $item->status )
         {
            $item->update(['status' => '0']);
            $case = 0;
         }
         else
         {
            $item->update(['status' => '1']);
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
           $deleted = City::destroy($id);
         } catch (\Exception $e) {
           return 'false';
         }
         return 'true';
    }

}
