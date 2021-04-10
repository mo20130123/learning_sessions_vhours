<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\AboutUs;

class AboutUsController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index()
    {
        return view('Admin.AboutUs.index');
    }

    //---api----
    public function get_list(Request $request)
    {
         $search = $request->search;
         return AboutUs::
          where(function($q)use($search){
              if ($search)
                $q->where('title','like','%'.$search.'%')->orWhere('body','like','%'.$search.'%')->orWhere('id',$search);
          })
          ->latest('id')->paginate();
    }

    public function store(Request $request)
    {
          $validator = \Validator::make($request->all(), [
              'image' => 'required',
              'title' => 'required',
              'body' => 'required',
          ]);
          if ($validator->fails()) { return response()->json([ 'state' => 'notValid' , 'data' => $validator->messages() ]);  }
          $item = AboutUs::create($request->except('_token'));
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
            'title' => 'required',
            'body' => 'required',
        ]);
        if ($validator->fails()) { return response()->json([ 'state' => 'notValid' , 'data' => $validator->messages() ]);  }

        $item = AboutUs::findOrFail($request->id);
        $item->update($request->except('_token'));
        return response()->json([
          'status' => 'success',
          'data' => $item
        ]);
    }

    //--api--
    public function showORhide($id)
    {
         $item = AboutUs::findOrFail($id);
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
           $deleted = AboutUs::destroy($id);
         } catch (\Exception $e) {
           return 'false';
         }
         return 'true';
    } 


}
