<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Product;
use App\HomeSlider;
use App\PagesBanner;
use App\ProductImages;
use DB;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('MemberNotRequiredJWTAndLangAndRate') ;
    }

    public function get_ChefRecommends_list(Request $request)
    {
         $AuthMember_id = $request->MemberID;
         $Products = Product::productsMinimal($AuthMember_id)
                ->where('products.is_bundle',0)
                // ->orderByRaw('FIELD(products.is_chef_rec , 1 ) Desc')
                ->where('products.is_chef_rec', 1)
                ->orderBy('products.position_chef')
                ->paginate(30);

          return collect(['status' => 'success'])->merge($Products);
    }

    public function get_NewArrivals_list(Request $request)
    {
         $AuthMember_id = $request->MemberID;
         $Products = Product::productsMinimal($AuthMember_id)
                ->where('products.is_bundle',0)
                // ->orderByRaw('FIELD(products.is_new , 1 ) Desc')
                ->where('products.is_new',1)
                ->orderBy('products.position_new')
                ->paginate(30);

        return collect(['status' => 'success'])->merge($Products);
    }

    public function get_Offers_list(Request $request)
    {
         $AuthMember_id = $request->MemberID;
         $Products = Product::productsMinimal($AuthMember_id)
                ->where('products.is_bundle',0)
                ->where('products.discount_percentage','>',0)
                ->orderBy('products.position_discount')
                ->paginate(30);

        return collect(['status' => 'success'])->merge($Products);
    }

    public function get_Bundle_list(Request $request)
    {
         $lang = $request->lang;
         $AuthMember_id = $request->MemberID;
         $Products = Product::productsQuery($AuthMember_id,[
                            'products.id as id',
                            "products.name_$lang as name" ,
                            "products.short_description_$lang as short_description",
                            'products.price',
                          DB::raw("if( shopping_cart.product_id , 1,0 ) as in_card"),
                          DB::raw("if( wish_list.product_id , 1,0 ) as in_wish_list"),
                          DB::raw("if( shopping_cart.quantity , shopping_cart.quantity,0 ) as in_card_quantity"),
                           "bundle_summary_$lang as bundle_label",'bundle_products_ids'])
                ->where('products.is_bundle',1)
                ->orderBy('products.position_bundle')
                ->paginate(35);
             foreach ($Products as $key => $bundle)
             {
                 $bundle->imagess = ProductImages::whereIn('product_id', explode(',', $bundle->bundle_products_ids) )
                                                 ->where('is_main',1)->pluck('image');
                 $bundle->bundel_first_image = $bundle->imagess[0]??'';
                 unset($bundle->bundle_products_ids);
                 unset($bundle->images);
             }
          return collect(['status' => 'success'])->merge($Products);
    }

    public function search_products_by_name(Request $request)
    {
        $validator = \Validator::make($request->all(), [
             'search' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([ 'status' => 'notValid' ,'status_message' => __('api.notValid') , 'missing_data' => $validator->messages() ]);
        }

        $lang = $request->lang;
        $search = $request->search;
        $AuthMember_id = $request->MemberID;
        $Products = Product::productsMinimal($AuthMember_id)
               ->where('products.is_bundle',0)
               ->where(function($q)use($search){
                    if($search)
                       $q->where('products.name_en','LIKE','%'.$search.'%')
                         ->orWhere('products.name_ar','LIKE','%'.$search.'%');
               })
               // ->orderByRaw('FIELD(products.is_chef_rec , 1 ) Desc')
               ->orderBy('products.position')
               ->paginate(30);
       return collect(['status' => 'success' ])->merge($Products);
    }

    public function product_details(Request $request,$product_id)
    {
         $AuthMember_id = $request->MemberID;
         $Product = Product::productsMinimal($AuthMember_id)
                ->where('products.is_bundle',0)
                ->where('products.id',$product_id)
                ->first();
                if(!$Product){
                    return response()->json([
                        'status' => 'failed',
                        'status_message' => 'wrong product id'
                    ]);
                }

            $Product->allowed_types = $Product->allowed_types ? explode(',', $Product->allowed_types): [];
            $Product->allowed_weight = $Product->allowed_weight ? explode(',', $Product->allowed_weight): [];

            $Product->images = ProductImages::where('product_id',$product_id)->pluck('image');

            $relatedProducts = \App\Product::productsMinimal($AuthMember_id)
                    ->orderByRaw('FIELD(products.sub_category_id , "'.$Product->sub_category_id.'"  ) Desc')
                    ->orderByRaw('FIELD(products.category_id , "'.$Product->category_id.'"  ) Desc')
                    ->where('products.id','!=',$product_id)
                    ->where('products.is_bundle',0)
                    ->limit(12)->get();

            return response()->json([
                'status' => 'success',
                'Product' => $Product ,
                'relatedProducts' => $relatedProducts ,
            ]);
    }

    public function bundle_details(Request $request,$product_id)
    {
        $AuthMember_id = $request->MemberID;
        $Product = Product::productsFull($AuthMember_id,false)
             ->where('products.is_bundle',1)
             ->where('products.id',$product_id)
             ->first();

             if(!$Product){
                 return response()->json([
                     'status' => 'failed',
                     'status_message' => 'wrong product id'
                 ]);
             }

         $bundle_items = Product::productsMinimal($AuthMember_id)
                            ->whereIn('products.id',explode(',', $Product->bundle_products_ids) )
                            ->get();
        $relatedProducts = \App\Product::productsMinimal($AuthMember_id)
                ->orderByRaw('FIELD(products.sub_category_id , "'.$Product->sub_category_id.'"  ) Desc')
                ->orderByRaw('FIELD(products.category_id , "'.$Product->category_id.'"  ) Desc')
                ->where('products.id','!=',$product_id)
                ->where('products.is_bundle',1)
                ->limit(12)->get();
          foreach ($relatedProducts as $key => $bundle)
          {
              $bundle->images = ProductImages::whereIn('product_id', explode(',', $bundle->bundle_products_ids) )
                                              ->where('is_main',1)->pluck('image');

          }

          return response()->json([
              'status' => 'success',
              'Product' => $Product ,
              'bundle_items' => $bundle_items ,
              'relatedProducts' => $relatedProducts ,
          ]);
    }

}
