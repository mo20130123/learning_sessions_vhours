<?php

namespace App\Http\Controllers\Site\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \App\Models\Product;
use App\Models\PagesBanner;
use DB;

class BestSellerController extends Controller
{

  public function __construct()
  {
     $this->middleware('auth:Member');
  }

  public function index()
  {
      $lang = \App::getLocale();
      $banner = PagesBanner::select('id',"image$lang as image",'link')
                             ->where('page','BestSeller')->first() ;

      return view('Site.products.Best_Seller',compact('banner'));
  }

  /*
   * Api
   * Post
   * Get list of products order by selles times number
   */
    public function list_products_orderBy_sellesTimesNo(Request $request)
    {
        $cat_id = $request->category_id;

        $lang = \App::getLocale();
        $Products = Product::productsMinimal()
                           ->where('is_bundle',0)
                           ->latest('selles_times_no')
                           ->paginate(25);

        return $Products;
    }


}
