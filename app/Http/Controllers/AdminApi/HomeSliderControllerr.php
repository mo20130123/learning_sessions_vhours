<?php

namespace App\Http\Controllers\AdminApi;

use Illuminate\Http\Request;
use App\Http\Controllers\vueAdminController;

use App\HomeSlider;

class HomeSliderControllerr extends vueAdminController
{
      public function __construct()
      {
         parent::__construct();
         $this->set_model_name('HomeSlider');

         $this->search_attrs =  [
              'id' , 'title'
         ];

         $this->sort_attrs =  [
              'id' , 'title as name' , 'position' , 'status'
         ];

         $this->store_attrs =  [
           'image_en' => 'required',
           'image_ar' => 'required',
           'title' => 'required',
           'link' => '',
           // 'body' => 'required',
         ];

         $this->update_attrs =  [
           'id' => 'required',
           'image_en' => '',
           'image_ar' => '',
           'title' => 'required',
           'link' => '',
           // 'body' => 'required',
         ];

      }//End __construc


}
