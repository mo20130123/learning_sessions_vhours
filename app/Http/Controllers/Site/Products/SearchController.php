<?php

namespace App\Http\Controllers\Site\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \App\Models\Product;
use App\Models\PagesBanner;
use DB;

class SearchController extends Controller
{

  public function __construct()
  {
     $this->middleware('auth:Member');
  }

  public function index(Request $request)
  {
      $search_text = $request->query('search_text');

      $lang = \App::getLocale();
      $banner = PagesBanner::select('id',"image$lang as image",'link')
                            ->where('page','Search')->first() ;


      return view('Site.products.Search',compact('banner','search_text'));
  }

  /*
   * Api
   * Post
   * Get list of products where is search
   */
    public function list_search(Request $request)
    {
        $search_text = $request->search_text;

        $lang = \App::getLocale();
        $Products = Product::productsMinimal()
                           ->where('is_bundle',0)
                           ->where(function($q)use($search_text){
                              if($search_text)
                                $q->where('name_en','like','%'.$search_text.'%')
                                  ->orWhere('name_ar','like','%'.$search_text.'%');
                           })
                           ->orderBy('position')
                           ->paginate(25);

        return $Products;
    }


}
