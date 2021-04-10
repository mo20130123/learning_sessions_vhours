<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\PagesBanner;
use App\Models\AboutList;
// use App\Setting;


class AboutUsController extends Controller
{
      public function index()
      {
          $lang = \App::getLocale();
          $Banner = PagesBanner::select("imageen as image" )
                                    ->where('page','About')->first();



          return view('Site.about',compact( 'Banner' )  );
      }


}
