<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Job;
use App\JobApplicant;
use App\PagesBanner;
use App\Setting;
use App\Applicant;

class CareerController extends Controller
{
      public function index()
      {
          $lang = \App::getLocale();
          $Banner = PagesBanner::select("imageen as image")
                                    ->where('page','Career')->first();

          return view('Site.Career',compact('Banner')  );
      }

      public function store(Request $request)
      {
            $validator = \Validator::make($request->all(),[
              'f_name' => 'required',
              'l_name' => 'required',
              'position' => 'required',
              'phone' => 'required',
              'email' => 'required', // |unique:job_applicants
              'resume' => 'required',
            ]);

            if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

            $JobApplicant = Applicant::create($request->all());

            \Session::flash('flash_message', __('page.Career_flash_message') );

            try {
              \Mail::to('jobs@superdelionline.com')
                    ->send(new \App\Mail\ApplicantRequest($JobApplicant));
            } catch (\Exception $e) {

            }

            return redirect('');

            // return response()->json([
            //   'status' => 'success',
            //   'flash_message' => __('page.Career_flash_message')
            // ]);
      }

}
