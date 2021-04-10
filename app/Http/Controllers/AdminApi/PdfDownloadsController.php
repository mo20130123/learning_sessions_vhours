<?php

namespace App\Http\Controllers\AdminApi;

use Illuminate\Http\Request;
use App\Http\Controllers\vueAdminController;

use App\PdfDownloads;

class PdfDownloadsController extends vueAdminController
{
                                   
  public function __construct()
  {
     parent::__construct();
     $this->set_model_name('PdfDownloads');

     $this->search_attrs =  [
          'id' , 'name_en' , 'name_ar'
     ];

     $this->sort_attrs =  [
          'id' , 'name_en as name' , 'position' , 'status'
     ];

     $this->store_attrs =  [
          'pdf' => 'required',
          'name_en' => 'required',
          'name_ar' => 'required',
     ];

     $this->update_attrs =  [
          'id' => 'required',
          'pdf' => '',
          'name_en' => 'required',
          'name_ar' => 'required',
     ];

  }//End __construct




}
