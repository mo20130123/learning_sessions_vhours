<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\vueAdminController;


// use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
//
// use App\HomeSlider;

class RefrenceCategoryController extends vueAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->set_model_name('RefrenceCategory');

        $this->search_attrs =  [
             'id' , 'name_en' , 'name_ar'
        ];

        $this->sort_attrs =  [
             'id' , 'name_en as name' , 'position' , 'status'
        ];

        $this->store_attrs =  [
            'name_en' => 'required',
            'name_ar' => 'required',
        ];

        $this->update_attrs =  [
            'id' => 'required',
            'name_en' => 'required',
            'name_ar' => 'required',
        ];

    }//End __construct






}
