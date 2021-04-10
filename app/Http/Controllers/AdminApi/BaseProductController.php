<?php

namespace App\Http\Controllers\AdminApi;

use Illuminate\Http\Request;
use App\Http\Controllers\vueAdminController;

use App\Models\BaseProduct;

class BaseProductController extends vueAdminController
{
    public function __construct()
    {
       parent::__construct();
       $this->set_model_name('BaseProduct');

       $this->vars_for_selections =  [
          'Categories' => \App\Models\Category::select('name_en as label','id as value')->get()
       ];


       $this->sort_attrs =  [
            'id' , 'name_en as name' , 'position' , 'status'
       ];

       $this->store_attrs =  [
           'category_id' => 'required',
           'name_en' => 'required',
           'name_ar' => 'required',
       ];

       $this->update_attrs =  [
           'id' => 'required',
           'category_id' => 'required',
           'name_en' => 'required',
           'name_ar' => 'required',
       ];

    }//End __construc

    public function get_list(Request $request)
    {
         $search = $request->search;
         $category_id = $request->category_id;
         return BaseProduct::select('base_products.*','categories.name_en as category_name')
          ->where(function($q)use($search){
              if ($search)
                $q->where('name_en','like','%'.$search.'%')->orWhere('name_ar','like','%'.$search.'%')
                  ->orWhere('id',$search);
          })
          ->where(function($q)use($category_id){
              if ($category_id)
                $q->where('category_id',$category_id);
          })
          ->leftJoin('categories','categories.id','base_products.category_id')
          ->groupBy('base_products.id')
          ->latest('base_products.id')->paginate();
    }


}
