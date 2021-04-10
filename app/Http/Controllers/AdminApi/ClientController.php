<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\vueAdminController;


// use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
//
// use App\HomeSlider;

class ClientController extends vueAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->set_model_name('Client');

        $this->search_attrs =  [
             'id' , 'name_en' , 'name_ar'
        ];

        $this->sort_attrs =  [
             'id' , 'name_en as name' , 'position' , 'status'
        ];

        $this->store_attrs =  [
            'image' => 'required',
            'name_en' => 'required',
            'name_ar' => 'required',
            'link' => '',
        ];

        $this->update_attrs =  [
            'id' => 'required',
            'name_en' => 'required',
            'name_ar' => 'required', 
            'link' => '',
            'image' => '',
        ];

    }//End __construct






}
