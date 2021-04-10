<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\SinglePageAdminController;


// use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
//
// use App\HomeSlider;

class ReceptSliderController extends SinglePageAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->set_model_name('ReceptSlider');

        $this->search_attrs =  [
             'id' , 'body_en' , 'body_ar'
        ];

        $this->sort_attrs =  [
             'id' , 'body_en as name' , 'position' , 'status'
        ];

        $this->store_attrs =  [
            'image' => 'required',
            'body_en' => 'required',
            'body_ar' => 'required',
            // 'link' => 'required',
            'image' => 'required',
        ];

        $this->update_attrs =  [
            'id' => 'required',
            'body_en' => 'required',
            'body_ar' => 'required',
            // 'link' => 'required',
            'image' => '',
        ];

    }//End __construct






}
