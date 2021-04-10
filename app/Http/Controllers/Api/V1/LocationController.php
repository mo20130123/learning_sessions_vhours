<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\City;
use App\District;

class LocationController extends Controller
{
   public function __construct()
    {
        $this->middleware('ApiLang') ;
    }

   public function get_list(Request $request)
   {
       $lang = $request->lang;
       $Cities = \App\City::select('id',"name_$lang as name")->where('status',1)->orderBy("name_$lang")->get();

       foreach ($Cities as $key => $City)
       {
           $City->Districts = District::select('id',"name_$lang as name")
                                      ->where('city_id',$City->id)->where('status',1)->orderBy("name_$lang")
                                      ->get();
       }
       return response()->json([
           'status' => 'success',
           'data' => $Cities ,
       ]);
   }


}
