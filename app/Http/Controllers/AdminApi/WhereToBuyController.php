<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\SinglePageAdminController;

// use Illuminate\Http\Request;

// use App\Category;

class WhereToBuyController extends SinglePageAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->set_model_name('WhereToBuy');

        $this->search_attrs =  [
             'id' , 'name_en' , 'name_ar'
        ];

        $this->sort_attrs =  [
             'id' , 'name_en as name' , 'position' ,'image', 'status'
        ];

        $this->store_attrs =  [
            'name_en' => 'required',
            'name_ar' => 'required',
            'image' => 'required',
            'location_link' => 'required',
        ];

        $this->update_attrs =  [
            'id' => 'required',
            'name_en' => 'required',
            'name_ar' => 'required',
            'image' => '',
            'location_link' => 'required',
        ];

    }//End __construct


}
