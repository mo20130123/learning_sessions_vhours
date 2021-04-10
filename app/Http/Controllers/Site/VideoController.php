<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\PagesBanner;
use App\Video;


class VideoController extends Controller
{
      public function index()
      {
          $lang = \App::getLocale();
          $navActive = 'Video';
          $Banner = PagesBanner::select("imageen as image","title_$lang as title","body_$lang as body")
                                    ->where('page','Video')->first();

          return view('Site.Video',compact('navActive' ,'Banner' )  );
      }


      public function get_list()
      {
          $lang = \App::getLocale();
          return Video::select('id',"title_$lang as title","description_$lang as description" ,'image','video_link')
             ->where('status',1)
             ->orderBy('position')
             ->paginate();
      }



}
