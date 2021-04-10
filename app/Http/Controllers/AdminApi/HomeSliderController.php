<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\vueAdminController;


// use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
//
// use App\HomeSlider;

class HomeSliderController extends vueAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->set_model_name('HomeSlider');

        $this->search_attrs =  [
             'id' , 'title_en' , 'title_ar'
        ];

        $this->sort_attrs =  [
             'id' , 'title_en as name' , 'position' , 'status'
        ];

        $this->store_attrs =  [
            'image' => 'required',
            'title_en' => 'required',
            'title_ar' => 'required',
            'body_en' => 'required',
            'body_ar' => 'required',
            'link' => '', 
        ];

        $this->update_attrs =  [
            'id' => 'required',
            'title_en' => 'required',
            'title_ar' => 'required',
            'body_en' => 'required',
            'body_ar' => 'required',
            'link' => '',
            'image' => '',
        ];

    }//End __construct






}
