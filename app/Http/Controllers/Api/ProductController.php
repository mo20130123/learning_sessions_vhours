<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\SinglePageAdminController;

// use Illuminate\Http\Request;

// use App\Category;

class ProductController extends SinglePageAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->set_model_name('Product');

        $this->vars_to_index = [
           'Categories' => \App\Category::select('id as value','name_en as label')->get()
        ];

        $this->search_attrs =  [
             'id' , 'name_en' , 'name_ar'
        ];

        $this->sort_attrs =  [
             'id' , 'name_en as name' , 'position' ,'image', 'status'
        ];

        $this->store_attrs =  [
            'category_id' => 'required',
            'name_en' => 'required',
            'name_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'image' => 'required',
        ];

        $this->update_attrs =  [
            'id' => 'required',
            'category_id' => 'required',
            'name_en' => 'required',
            'name_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'image' => '',
        ];

    }//End __construct


    public function index(){
       $Categories = \App\Category::select('id as value','name_en as label')->get();
       
   }

}
