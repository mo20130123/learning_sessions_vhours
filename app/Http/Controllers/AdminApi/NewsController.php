<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\SinglePageAdminController;


use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
//
use App\News;

class NewsController extends SinglePageAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->set_model_name('News');

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
            'pref_description_en' => 'required',
            'pref_description_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
        ];

        $this->update_attrs =  [
            'id' => 'required',
            'image' => '',
            'title_en' => 'required',
            'title_ar' => 'required',
            'pref_description_en' => 'required',
            'pref_description_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
        ];

    }//End __construct



}
