<?php

namespace App\Http\Controllers\AdminApi;

use Illuminate\Http\Request;
use App\Http\Controllers\vueAdminController;

class DistrictController extends vueAdminController
{

    public function __construct()
    {
       parent::__construct();
       $this->set_model_name('District');

       $this->search_attrs =  [
            'id' , 'name_en' , 'name_ar'
       ];

       $this->vars_for_selections =  [
          'Cities' => \App\City::select('name_en as label','id as value')->get()
       ];


       $this->sort_attrs =  [
            'id' , 'name_en as name' , 'position' , 'status'
       ];

       $this->store_attrs =  [
            'city_id' => 'required',
            'name_en' => 'required',
            'name_ar' => 'required',
       ];

       $this->update_attrs =  [
            'id' => 'required',
            'city_id' => 'required',
            'name_en' => 'required',
            'name_ar' => 'required',
       ];

    }//End __construct

    //---api----
    public function get_list(Request $request)
    {
         $search = $request->search;
         $city_id = $request->city_id;
         return \App\District::select('districts.*','cities.name_en as city_name')
          ->where(function($q)use($search){
              if ($search)
                $q->where('districts.name_en','like','%'.$search.'%')
                  ->orWhere('districts.name_ar','like','%'.$search.'%')->orWhere('districts.id',$search);
          })
          ->where(function($q)use($city_id){
              if ($city_id)
                $q->where('cities.id',$city_id);
          })
          ->join('cities','cities.id','districts.city_id')
          ->groupBy('districts.id')
          ->latest('id')->paginate();
    }

}
