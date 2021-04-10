<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\vueAdminController;


// use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
//
// use App\HomeSlider;

class TermsAndConditionsController extends vueAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->set_model_name('TermsAndConditions');

        $this->search_attrs =  [
             'id' , 'title_en' , 'title_ar'
        ];

        $this->sort_attrs =  [
             'id' , 'title_en as name' , 'position' , 'status'
        ];

        $this->store_attrs =  [
            'title_en' => 'required',
            'title_ar' => 'required',
            'text_en' => 'required',
            'text_ar' => 'required',
        ];

        $this->update_attrs =  [
            'id' => 'required',
            'title_en' => 'required',
            'title_ar' => 'required',
            'text_en' => 'required',
            'text_ar' => 'required',
        ];

    }//End __construct






}
