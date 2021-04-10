<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\vueAdminController;


use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
//
use App\JobApplicant;

class JobController extends vueAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->set_model_name('Job');

        $this->search_attrs =  [
             'id' , 'title_en' , 'title_ar'
        ];

        $this->sort_attrs =  [
             'id' , 'title_en as name' , 'position' , 'status'
        ];

        $this->store_attrs =  [
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
        ];

        $this->update_attrs =  [
            'id' => 'required',
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
        ];

    }//End __construct

//+++++++++++++++++++++++++++++++++++++ Applicants ++++++++++++++++++++++++++++++++++++++

    public function job_applicants($job_id,Request $request)
    {
         $search = $request->search;
         $connection = $request->connection;

        $Job = \App\Job::findOrFail($job_id);
        $JobApplicant = \App\JobApplicant::where('job_id',$job_id)
                       ->where(function($q)use($connection){
                            if($connection)
                            {
                                switch ($connection)
                                {
                                  case 'contacted':
                                       $q->where('is_contacted',1);
                                    break;
                                  case 'notContacted':
                                       $q->where('is_contacted',0);
                                    break;
                                }
                            }
                     })
                     ->where(function($q)use($search ){
                        if ($search)
                          $q->where('name','like','%'.$search.'%')
                           ->where('phone','like','%'.$search.'%')->orWhere('email','like','%'.$search.'%')
                           ->orWhere('id',$search);
                    })
                     ->latest('id')->limit(500)->get();

        return response()->json([
          'status' => 'success',
          'Job' => $Job ,
          'Applicants' => $JobApplicant
        ]);
    }


     public function switch_contacted($id)
     {
           $Applicant = JobApplicant::findOrFail($id);
           if( $Applicant->is_contacted )
           {
              $Applicant->update(['is_contacted' => '0']);
              $case = 0;
           }
           else
           {
              $Applicant->update(['is_contacted' => '1']);
              $case = 1;
           }

           return response()->json([
              'status' => 'success',
              'case' => $case
           ]);
     }
 
     public function applicant_destroy($id)
     {
           try {
             $deleted = JobApplicant::destroy($id);
           } catch (\Exception $e) {
             return 'false';
           }
           return 'true';
     }


}
