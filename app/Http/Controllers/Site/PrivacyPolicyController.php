<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\PrivacyPolicy;
use App\Models\PagesBanner;

class PrivacyPolicyController extends Controller
{
      public function index()
      {
            $lang = \App::getLocale();
            $PrivacyPolicys = PrivacyPolicy::select('id',"title_$lang as title","text_$lang as text")
                                             ->orderBy('position')->where('status',1)->get();

            $banner = PagesBanner::where('page','PrivacyPolicy')->first()["image$lang"];

             return view('Site.PrivacyPolicy',compact('PrivacyPolicys','banner') );
      }

 }
