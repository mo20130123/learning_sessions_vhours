<?php

namespace App\Http\Controllers\SiteNew;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\PagesBanner;
use App\Brand;
use App\Product;
use App\HomeAdvertising;

class ShopListController extends Controller
{
    public function index()
    {
          $lang = \App::getLocale();
          $AuthMember_id = ( auth('Member')->check() )? auth('Member')->id() : 0 ;
          $brands = Brand::select( "name_$lang as name",'id','logo','in_home_page')->where('status',1)->orderBy('in_home_page_order')->get();
          foreach ($brands as $key => $brand)
          {
               if($brand->in_home_page) {
                    $brand->products = Product::select('products.id as id','products.brand_id','products.category_id',
                                      "products.name_$lang as name" ,"bags_$lang as bage","products.quantity as quantity",
                                      "products.quantity as quantity",
                                      "prev_description_$lang as prev_description","description_$lang as description",
                                      'products.price',"products.old_price as old_price","products.discount_percentage as discount_percentage",
                                      \DB::raw("CONCAT('".asset('images/ProductImages')."/',product_images.image) as image"),
                                      \DB::raw("GROUP_CONCAT(CONCAT('".asset('images/ProductImages')."/',product_images.image)) as images"),
                                      \DB::raw("if( shopping_cart.product_id , 1,0 ) as in_card"),
                                      \DB::raw("if( shopping_cart.quantity , shopping_cart.quantity,0 ) as in_card_quantity")
                                    )

                            ->join('product_images','product_images.product_id','products.id')->groupBy('products.id')
                            ->leftJoin('shopping_cart',function($q)use($AuthMember_id){
                                $q->on('shopping_cart.product_id','products.id')->where('shopping_cart.member_id',$AuthMember_id);
                            })

                            ->where('status',1)->where('products.brand_id',$brand->id)->latest('products.id')->limit(4)->get();
               }
               else {
                 $brand->products = [];
               }
          }

          $Advertising = HomeAdvertising::where('status',1)->get();

          return view('Site.shop.index',compact('brands','Advertising'));
      }

      // public function productsList(Request $request)
      // {
      //       $data = $request->validate([
      //         'name' => 'required',
      //         'phone' => 'required',  // |unique:register,email
      //         'email' => 'required',
      //     ]);
      //
      //     \App\Register::create($data);
      //     \Session::flash('flash_message','Thank you for your interest in AGORA, one of our representative will contact you soon. ');
      //     return back();
      // }

}
