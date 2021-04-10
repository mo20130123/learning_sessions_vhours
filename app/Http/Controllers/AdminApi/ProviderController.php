<?php

namespace App\Http\Controllers\AdminApi;

use Illuminate\Http\Request;
use App\Http\Controllers\vueAdminController;

use App\Provider;
use App\Category;
use App\SubCategory;
use App\HomePage;

class ProviderController extends vueAdminController
{

    public function __construct()
    {
       parent::__construct();
       $this->set_model_name('Provider');

       $this->search_attrs =  [
            'id' , 'name_en' , 'name_ar'
       ];

       $this->sort_attrs =  [
            'id' , 'name_en as name' , 'position' , 'status'
       ];

       $this->store_attrs =  [
           'logo' => 'required',
           'name_en' => 'required',
           'name_ar' => 'required',
           'overview_en' => '',
           'overview_ar' => '',
           'image' => '',
           'instagram_link' => '',
           'youtube_link' => '',
           'facebook_link' => '',
           'twitter_link' => '',
       ];

       $this->update_attrs =  [
            'id' => 'required',
            'logo' => '',
            'name_en' => 'required',
            'name_ar' => 'required',
            'overview_en' => '',
            'overview_ar' => '',
            'image' => '',
            'instagram_link' => '',
            'youtube_link' => '',
            'facebook_link' => '',
            'twitter_link' => '',
       ];

    }//End __construc



}
