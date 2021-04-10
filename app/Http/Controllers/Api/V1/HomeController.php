<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Product;
use App\HomeSlider;
use App\PagesBanner;
use App\ProductImages;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('MemberNotRequiredJWTAndLangAndRate') ;
    }

   public function Home_list(Request $request)
   {
     $lang = $request->lang;
     $AuthMember_id = $request->MemberID;

     $HomeSliders = HomeSlider::select('id',"image_$lang as image",'link')->where('status',1)->orderBy('position')->get();

     $banner = PagesBanner::select('id',"image$lang as image",'link')
                          ->where('page','home_1')->orWhere('page','home_2')->get() ;

     $banner_1 = $banner->first(function($item) { return $item->id == 8;  });
     $banner_2 = $banner->first(function($item) { return $item->id == 16; });

      $items_chef_rec =
             Product::productsMinimal($AuthMember_id)
                ->where('products.is_chef_rec',1)
             // ->orderByRaw('FIELD(products.category_id , "'.$Page->category_id.'"  ) Desc')
                ->orderBy('products.position_chef')
                ->limit(12)->get();

      $items_bundles =
             Product::productsMinimal($AuthMember_id)
                ->where('products.is_bundle',1)
                ->orderBy('products.position')
                ->limit(3)->get();
      foreach ($items_bundles as $key => $bundle)
      {
          $bundle->images = ProductImages::whereIn('product_id', explode(',', $bundle->bundle_products_ids) )
                                          ->where('is_main',1)->pluck('image');
      }

      $items_NewArrivals =
                Product::productsMinimal($AuthMember_id)
                ->where('products.is_bundle',0)
                ->where('products.is_new', 1)
                ->orderBy('products.position_new')
                ->limit(12)->get();

      $items_discounts =
             Product::productsMinimal($AuthMember_id)
                   ->where('products.is_bundle',0)
                   ->where('products.discount_percentage','>',0)
                   ->orderBy('products.position_discount')
                   ->limit(12)->get();


       return response()->json([
           'status' => 'success',
           'banner_1' => $banner_1 ,
           'banner_2' => $banner_2 ,
           'HomeSliders' => $HomeSliders ,
           'items_chef_rec' => $items_chef_rec ,
           'items_NewArrivals' => $items_NewArrivals ,
           'items_discounts' => $items_discounts ,
           'items_bundles' => $items_bundles ,
       ]);
   }


}
