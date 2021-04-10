<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Setting;
use App\Models\ContactUs;
use App\Models\PagesBanner;

class ContactUsController extends Controller
{
      public function index()
      {
          $contactus_description = Setting::where('title','contactus_description')->first();

          $Banner = PagesBanner::select("imageen as image" )
                                    ->where('page','Contact_us')->first();

          return view('Site.Contact_us',compact('contactus_description','Banner'));
      }

      public function make_Contact(Request $request)
      {
            $data = $request->validate([
              'name' => 'required',
              'company' => 'required',
              'email' => 'required',
              'phone' => 'required',  // |unique:register,email
              'topic' => 'required',
              'message' => 'required',
          ]);

        $ContactUs = ContactUs::create($data);

          \Session::flash('flash_message', __('api.Thank you for your interest in DeleDael') );

            // try {
            //     \Mail::to('info@superdelionline.com')
            //     ->send(new \App\Mail\ContactUs($ContactUs));
            // } catch (\Exception $e) {
            // }

          return back();
      }
}
