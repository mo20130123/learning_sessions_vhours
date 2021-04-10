<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\HomeSlider;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\PagesBanner;
use App\Models\TrustedBy;
use DB;


class HomeController extends Controller
{

      public function __construct()
      {
         $this->middleware('auth:Member');
         // $this->middleware('checkIfMemberNeedToRateLastOrder')->only('index');
      }

      public function index()
      {
          $lang = \App::getLocale();
          $AuthMember_id = ( auth('Member')->check() )? auth('Member')->id() : 0 ;
          // $HomeSliders = HomeSlider::select('id',"image_$lang as image",'link')->where('status',1)->orderBy('position')->get();

          $banner = PagesBanner::select('id',"image$lang as image",'link')
                               ->where('page','home_1')->orWhere('page','home_2')->get() ;

          $banner_1 = $banner->first(function($item) { return $item->id == 8;  });
          $banner_2 = $banner->first(function($item) { return $item->id == 16; });

          $TrustedBy = TrustedBy::where('status',1)->orderBy('position')->get();

          $BestSellers = Product::productsMinimal()
                                ->where('is_bundle',0)
                                ->latest('selles_times_no')
                                ->limit(7)->get();  

          $Offers = Product::productsMinimal()
                                ->where('is_bundle',0)
                                ->where('offer_percentage','>=',1)
                                ->latest('selles_times_no')
                                ->limit(7)->get();

          $Bundles = Product::BundleMinimal()
                                ->latest('position')
                                ->limit(5)->get();
// return $Bundles;
            return view('Site.home',compact('TrustedBy','BestSellers','Offers','Bundles'));
      }



      public function make_register(Request $request)
      {
            $data = $request->validate([
              'name' => 'required',
              'phone' => 'required',  // |unique:register,email
              'email' => 'required',
          ]);

          \App\Register::create($data);
          \Session::flash('flash_message','Thank you for your interest in AGORA, one of our representative will contact you soon. ');
          return back();
      }

}
