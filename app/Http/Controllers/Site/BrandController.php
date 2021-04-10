<?php

namespace App\Http\Controllers\SiteNew;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Brand;
use App\Category;
use App\Product;

class BrandController extends Controller
{
      public function index($id)
      {
          $lang = \App::getLocale();
          $Brand = Brand::select('*',"name_$lang as name","og_description_$lang as og_description")->findOrFail($id);
          $Categories = Category::select("name_$lang as name",'id','brand_id')
                    ->where('status',1)->where('brand_id',$id)->get();

          return view('Site.brand.list',compact('Categories','Brand'));
      }

      public function productsList(Request $request)
      {
          $data = $request->validate([
              'brand_id' => 'required',
              'category_ids' => '', //array
          ]);
          $lang = \App::getLocale();
          $AuthMember_id = ( auth('Member')->check() )? auth('Member')->id() : 0 ;
          $category_ids = $request->category_ids;
          $Products = \App\Product::select('products.id as id','products.brand_id','products.category_id','products.price',
                            "products.name_$lang as name" ,"bags_$lang as bage","products.quantity as quantity",
                            "prev_description_$lang as prev_description","description_$lang as description",'position',
                            \DB::raw("CONCAT('".asset('images/ProductImages')."/',product_images.image) as image"),
                            \DB::raw("GROUP_CONCAT('".asset('images/ProductImages')."/',product_images.image) as images"),
                            \DB::raw("if( shopping_cart.product_id , 1,0 ) as in_card"),
                            \DB::raw("if( shopping_cart.quantity , shopping_cart.quantity,0 ) as in_card_quantity")
                         )

                      ->join('product_images','product_images.product_id','products.id')->groupBy('products.id')
                      ->leftJoin('shopping_cart',function($q)use($AuthMember_id){
                          $q->on('shopping_cart.product_id','products.id')->where('shopping_cart.member_id',$AuthMember_id);
                      })
                      ->where('products.status',1)
                      ->where('brand_id',$request->brand_id)
                      ->where(function($q)use ($category_ids){
                          if($category_ids){
                             $q->whereIn('category_id',$category_ids);
                          }
                      })
                      ->orderBy('position')
                      ->paginate();
           return $Products ;
      }

}
