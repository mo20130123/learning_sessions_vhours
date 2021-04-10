<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\PagesBanner;
use App\DeliveryPolicy;

class DeliveryPolicyController extends Controller
{
      public function index()
      {
          $lang = \App::getLocale();

          $PrivacyPolicys = DeliveryPolicy::select('id',"title_$lang as title","text_$lang as text")
                                           ->orderBy('position')->where('status',1)->get();

          $banner = PagesBanner::where('page','DeliveryPolicy')->first()["image$lang"];

          return view('Site.delivery-policy',compact( 'banner','PrivacyPolicys' )  );
      }


}
