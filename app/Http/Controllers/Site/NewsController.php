<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\News;
use App\PagesBanner;
use DB;


class NewsController extends Controller
{
      public function index()
      {
          $lang = \App::getLocale();
          $navActive = 'News';
          $Banner = PagesBanner::select("imageen as image","title_$lang as title","body_$lang as body")
                                    ->where('page','news')->first();

          return view('Site.News' ,compact('Banner','navActive') );
      }

      public function get_list()
      {
          $lang = \App::getLocale();
          return News::select('id',"title_$lang as title",
                          "pref_description_$lang as pref_description","description_$lang as description",'image',
                          \DB::raw("false as is_opend") )
             ->where('status',1)
             ->orderBy('position')
             ->paginate();
      }


}
