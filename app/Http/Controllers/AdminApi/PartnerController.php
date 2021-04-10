<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Partner;

class PartnerController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index()
    {
        return view('Admin.Partner.index');
    }

    //---api----
    public function get_list(Request $request)
    {
         $search = $request->search;
         return Partner::
          where(function($q)use($search){
              if ($search)
                $q->where('name','like','%'.$search.'%')->orWhere('link','like','%'.$search.'%')->orWhere('id',$search);
          })
          ->latest('id')->paginate();
    }

    public function store(Request $request)
    {
          $validator = \Validator::make($request->all(), [
              'image' => 'required',
              'name' => 'required',
              'link' => '',
          ]);
          if ($validator->fails()) { return response()->json([ 'state' => 'notValid' , 'data' => $validator->messages() ]);  }
          $item = Partner::create($request->except('_token'));
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
            'image' => '',
            'name' => 'required',
            'link' => '',
        ]);
        if ($validator->fails()) { return response()->json([ 'state' => 'notValid' , 'data' => $validator->messages() ]);  }

        $item = Partner::findOrFail($request->id);
        $item->update($request->except('_token'));
        return response()->json([
          'status' => 'success',
          'data' => $item
        ]);
    }

    //--api--
    public function showORhide($id)
    {
         $item = Partner::findOrFail($id);
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
           $deleted = Partner::destroy($id);
         } catch (\Exception $e) {
           return 'false';
         }
         return 'true';
    }

}
