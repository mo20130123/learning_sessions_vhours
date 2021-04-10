<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\PagesBanner;
use App\RefrenceCategory;
use App\Refrence;
use App\RefrenceImages;
// use App\Setting;


class RefrenceController extends Controller
{
      public function index()
      {
          $lang = \App::getLocale();
          $navActive = 'Refrence';
          $Banner = PagesBanner::select("imageen as image","title_$lang as title","body_$lang as body")
                                    ->where('page','Refrence')->first();
          $Categories = RefrenceCategory::select('id',"name_$lang as name" )
                                ->where('status',1)->orderBy('position')->get();

          return view('Site.Refrences.Refrences_list',compact('navActive','Banner','Categories')  );
      }

      public function show($id)
      {
          $lang = \App::getLocale();
           $navActive = 'Refrence';

           $Banner = PagesBanner::select("imageen as image","title_$lang as title","body_$lang as body")
                                    ->where('page','Refrence')->first();

           $Refrence = Refrence::select('*',"name_$lang as name","description_$lang as description",
                                         "colour_$lang as colour","pile_height_$lang as pile_height",
                                         "stitch_density_$lang as stitch_density","machine_gauge_$lang as machine_gauge"
                                       )  
           ->where('status',1)
           ->where('id',$id)
           ->orderBy('position')->first();

           if(!$Refrence){
             return redirect('/');
          }

           $Images = RefrenceImages::where('refrence_id',$Refrence->id)->get();

          return view('Site.Refrences.Refrences-show',compact('navActive','Refrence','Images','Banner') );
      }

      public function get_list(Request $request)
      {
          $lang = \App::getLocale();
          $category_id = $request->category_id;

             return Refrence::select('refrences.*','P_images.image as image',"name_$lang as name",
                                     "description_$lang as description")
                     ->where(function($q)use($category_id){
                        if ($category_id)
                           $q->where('category_id',$category_id);
                     })
                     ->leftJoin('refrence_images as P_images',function($j){
                        $j->on('P_images.refrence_id','refrences.id')->where('is_main',1);
                     })
                     ->where('status',1)
                     ->orderBy('position')->paginate(20);
      }

      public function searchPage(Request $request)
      {
          $data = $request->validate([
            'search' => 'required',
          ]);

          $lang = \App::getLocale();
          $navActive = 'Refrence';
          $search = $request->search;
          return view('Site.products.search',compact( 'navActive','search'));
      }

}
