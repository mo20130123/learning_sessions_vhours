<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\PagesBanner;
use App\Service;
// use App\Setting;


class ServiceController extends Controller
{
      public function index()
      {
          $lang = \App::getLocale();
          $navActive = 'Service';
          $Banner = PagesBanner::select("imageen as image","title_$lang as title","body_$lang as body")
                                    ->where('page','Service')->first();

          $Services = Service::select('id',"description_$lang as description","name_$lang as name",'image')
                            ->where('status',1)->orderBy('position')->get();


          return view('Site.services',compact('navActive','Banner','Services' )  );
      }


}
