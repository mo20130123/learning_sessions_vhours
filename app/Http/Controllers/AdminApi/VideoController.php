<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\SinglePageAdminController;

// use Illuminate\Http\Request;

// use App\Category;

class VideoController extends SinglePageAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->set_model_name('Video');

        $this->search_attrs =  [
             'id' , 'title_en' , 'title_ar'
        ];

        $this->sort_attrs =  [
             'id' , 'title_en as name' , 'position' ,'image', 'status'
        ];

        $this->store_attrs =  [
            'title_en' => 'required',
            'title_ar' => 'required',
            'image' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'video_link' => 'required',
        ];

        $this->update_attrs =  [
            'id' => 'required',
            'title_en' => 'required',
            'title_ar' => 'required',
            'image' => '',
            'description_en' => 'required',
            'description_ar' => 'required',
            'video_link' => 'required',
        ];

    }//End __construct


}
