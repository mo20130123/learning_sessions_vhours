<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\TermsAndConditions;
use App\Models\PagesBanner;

class TermsController extends Controller
{
      public function index()
      {
          $lang = \App::getLocale();
          $Terms = TermsAndConditions::select('id',"title_$lang as title","text_$lang as text")
                                           ->orderBy('position')->where('status',1)->get();

          $banner = PagesBanner::where('page','TermsAndConditions')->first()["image$lang"];

          return view('Site.TermsAndConditions',compact('Terms','banner') );
      }

 }
