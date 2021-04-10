<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\vueAdminController;


use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
//
use App\ProductSubCategory;

class ProductSubCategoryController extends vueAdminController
{

    public function __construct()   // selection_data
    {
        parent::__construct();
        $this->set_model_name('ProductSubCategory');

        $this->vars_for_selections =  [
           'ProductCategories' => \App\ProductCategory::select('id as value','name_en as label')->get()
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

    }//End __construct


    public function get_list(Request $request)
    {
           $search = $request->search;
           $category_id = $request->category_id;

           $data = ProductSubCategory::
            where(function($q)use($search){
                if ($search)
                {
                    $q->where('id',$search)
                      ->orWhere('name_en','like','%'.$search.'%')->orWhere('name_ar','like','%'.$search.'%');
                }//End if
             })
            ->where(function($q)use($category_id){
                if($category_id){
                   $q->where('category_id',$category_id);
                }
             })
            ->latest('id')->paginate();
            return collect(['status' => 'success'])->merge($data);
    }



}
