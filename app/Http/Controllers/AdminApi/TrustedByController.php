<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\vueAdminController;


// use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
//
// use App\HomeSlider;

class TrustedByController extends vueAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->set_model_name('TrustedBy');

        $this->search_attrs =  [
             'id' , 'name'
        ];

        $this->sort_attrs =  [
             'id' , 'name' , 'position' , 'status'
        ];

        $this->store_attrs =  [
            'image' => 'required',
            'name' => 'required',
            'image' => 'required',
        ];

        $this->update_attrs =  [
            'id' => 'required',
            'name' => 'required',
            'image' => '',
        ];

    }//End __construct






}
