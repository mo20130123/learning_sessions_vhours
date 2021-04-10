<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\vueAdminController;


// use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
//
// use App\HomeSlider;

class SeoKeywordsController extends vueAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->set_model_name('SeoKeywords');

        $this->search_attrs =  [
             'id' , 'name'
        ];

        $this->store_attrs =  [
            'name' => 'required',
        ];

        $this->update_attrs =  [
            'id' => 'required',
            'name' => 'required', 
        ];

    }//End __construct






}
