<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\PagesBanner;
use App\Partner;
use App\Setting;


class PartnerController extends Controller
{
      public function index()
      {
          $lang = \App::getLocale();
          $navActive = 'Partner';
          $Banner = PagesBanner::select("imageen as image","title_$lang as title","body_$lang as body")
                                    ->where('page','Partner')->first();

          return view('Site.Partner',compact('navActive','Banner' )  );
      }

      public function get_list()
      {
          $lang = \App::getLocale();
          return Partner::select('id',"name" ,'image' )
             ->where('status',1)
             ->orderBy('position')
             ->paginate();
      }


}
