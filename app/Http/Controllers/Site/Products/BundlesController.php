<?php

namespace App\Http\Controllers\Site\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \App\Models\Product;
use App\Models\PagesBanner;
use DB;

class BundlesController extends Controller
{

  public function __construct()
  {
     $this->middleware('auth:Member');
  }

  public function index()
  {
      $lang = \App::getLocale();
      $banner = PagesBanner::select('id',"image$lang as image",'link')
                            ->where('page','Bundles')->first() ;

      return view('Site.products.Bundles',compact('banner'));
  }

  /*
   * Api
   * Post
   * Get list of products where is Bundles
   */
    public function list_Bundles(Request $request)
    {
        $cat_id = $request->category_id;

        $lang = \App::getLocale();
        $Bundles = Product::BundleMinimal()
                           ->where('is_bundle',1)
                           ->orderBy('position')
                           ->paginate(25);

        return $Bundles;
    }


}
