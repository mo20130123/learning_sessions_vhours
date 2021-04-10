<?php

namespace App\Http\Controllers\AdminApi;
 
use App\Http\Controllers\vueAdminController;


class PopularQuestionController extends vueAdminController
{

    public function __construct()
    {
       parent::__construct();
       $this->set_model_name('PopularQuestion');

       $this->search_attrs =  [
            'id' , 'question_en' , 'question_ar'
       ];

       $this->sort_attrs =  [
            'id' , 'question_en as name' , 'position' , 'status'
       ];

       $this->store_attrs =  [
            'question_en' => 'required',
            'question_ar' => 'required',
            'answer_en' => 'required',
            'answer_ar' => 'required',
       ];

       $this->update_attrs =  [
            'id' => 'required',
            'question_en' => 'required',
            'question_ar' => 'required',
            'answer_en' => 'required',
            'answer_ar' => 'required',
       ];

    }//End __construc


}
