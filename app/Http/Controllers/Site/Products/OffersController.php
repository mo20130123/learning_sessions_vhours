<?php

namespace App\Http\Controllers\Site\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \App\Models\Product;
use App\Models\PagesBanner;
use DB;

class OffersController extends Controller
{

  public function __construct()
  {
     $this->middleware('auth:Member');
  }

  public function index()
  {
      $lang = \App::getLocale();
      $banner = PagesBanner::select('id',"image$lang as image",'link')
                            ->where('page','Offers')->first() ;

      return view('Site.products.Offers',compact('banner'));
  }

  /*
   * Api
   * Post
   * Get list of products where is offer
   */
    public function list_products_offers(Request $request)
    {
        $cat_id = $request->category_id;

        $lang = \App::getLocale();
        $Products = Product::productsMinimal()
                           ->where('is_bundle',0)
                           ->where('offer_percentage','>',0)
                           ->orderBy('position')
                           ->paginate(25);

        return $Products;
    }


}
