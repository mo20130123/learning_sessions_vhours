<?php

namespace App\Http\Controllers\Site\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPackageBasic;
use App\Models\ProductPackageStandard;
use App\Models\ProductPackagePremium;
use App\Models\ProductImages;
use DB;

class ProductController extends Controller
{

    public function __construct()
    {
       $this->middleware('auth:Member');
       // $this->middleware('checkIfMemberNeedToRateLastOrder') ;
    }


   public function searchPage(Request $request)
   {
      $data = $request->validate([
         'search' => 'required',
      ]);

      $lang = \App::getLocale();
      $search = $request->search;
      return view('Site.products.Search',compact( 'search'));
   }


   //================================================================
   //=========================== Apis ===============================
   //================================================================

   public function get_Products_list(Request $request)
   {
        $categories = $request->categories;
        $brand_id = $request->brand_id;
        $search = $request->search;
        $lang = \App::getLocale();

        $AuthMember_id = ( auth('Member')->check() )? auth('Member')->id() : 0 ;
        return  Product::select('products.id as id','products.category_id',
                         "products.name_$lang as name" ,"products.quantity as quantity",
                         "products.short_description_$lang as short_description",
                         'products.price',"products.old_price as old_price","products.discount_percentage as discount_percentage",
                         "description_$lang as description","bundle_summary_$lang as bundle_summary",
                         "product_images.image as image",
                         DB::raw("GROUP_CONCAT(CONCAT('".asset('images/ProductImages')."/',product_images.image)) as images"),
                         'is_chef_rec','is_bundle','bundle_products_ids','have_type_and_weight',
                         DB::raw("if( products.discount_percentage > 0 , 1,0 ) as is_discount"),
                         'products.is_new','products.allowed_types','shopping_cart.cheese_type',
                         // DB::raw("if( date_add(products.created_at,INTERVAL 1 MONTH) > NOW() , 1,0 ) as is_new"),
                       // DB::raw("CONCAT('".url('category')."/',sub_categories.id,'-',sub_categories.name_$lang) as url_sub_cat"),
                       DB::raw("if( shopping_cart.product_id , 1,0 ) as in_card"),
                       DB::raw("if( shopping_cart.quantity , shopping_cart.quantity,0 ) as in_card_quantity"),
                       DB::raw("if( wish_list.product_id , 1,0 ) as in_wish_list")
                    )
               ->groupBy('products.id')
               ->leftJoin('product_images',function($q){
                   $q->on('product_images.product_id','products.id')->where('product_images.is_main',1);
               })
               ->leftJoin('shopping_cart',function($q)use($AuthMember_id){
                   $q->on('shopping_cart.product_id','products.id')->where('shopping_cart.member_id',$AuthMember_id);
               })
               ->leftJoin('wish_list',function($q)use($AuthMember_id){
                   $q->on('wish_list.product_id','products.id')->where('wish_list.member_id',$AuthMember_id);
               })
               ->leftJoin('sub_categories','sub_categories.id','products.sub_category_id')
               ->leftJoin('products_key_words','products_key_words.product_id','products.id')
               ->where('products.status',1)
               ->where('products.is_bundle',0)
               ->where(function($q)use($search){
                     if($search)
                        $q->where('products.name_en','LIKE','%'.$search.'%')
                          ->orWhere('products.name_ar','LIKE','%'.$search.'%')
                          ->orWhere('products_key_words.name_en','LIKE','%'.$search.'%')
                          ->orWhere('products_key_words.name_ar','LIKE','%'.$search.'%');
               })
               ->orderBy('products.position')
               ->paginate(30);
   }


   public function get_subCats_list($SubCat_id)
   {
        return Product::productsFULL()
               ->where('products.is_bundle',0)
               ->where('products.sub_category_id',$SubCat_id)
               ->orderBy('products.position')
               ->paginate(30);
   }


    public function show($id)
    {
          $lang = \App::getLocale();
          $AuthMember_id = ( auth('Member')->check() )? auth('Member')->id() : 0 ;

          $Images = ProductImages::where('product_id',$id)->pluck('image');

          $select_arr = [
             'products.id as id','products.category_id', "products.name_$lang as name" ,
             "products.short_description_$lang as short_description",'youtube_link',
             "description_$lang as description", 'is_bundle',
             "products.offer_percentage as offer_percentage",'is_available',
             DB::raw("if( shopping_cart.product_id , 1,0 ) as in_card"),
             DB::raw("if( wish_list.product_id , 1,0 ) as in_wish_list"),
             "description_$lang as description","requirements_$lang as requirements",'provider_id',
             'have_BasicPakage','have_StandardPakage','have_PremiumPakage'
          ];

          $product = Product::select($select_arr)
                   ->groupBy('products.id')
                   ->leftJoin('shopping_cart',function($q)use($AuthMember_id){
                       $q->on('shopping_cart.product_id','products.id')->where('shopping_cart.member_id',$AuthMember_id);
                   })
                   ->leftJoin('wish_list',function($q)use($AuthMember_id){
                       $q->on('wish_list.product_id','products.id')->where('wish_list.member_id',$AuthMember_id);
                   })
                   ->where('products.status',1)
                   ->where('products.id',$id)
                   ->with('PackageBasic')
                   ->with('PackageStandard')
                   ->with('PackagePremium')
                   ->with('PackageBundle')
                   ->with('Provider')
                   ->first();
                  if(!$product){
                    // return 'hidden Item';
                    return redirect('');
                  }

                  $product_keywords = '';
                  foreach ($product->keywords as $keyword) {
                       $product_keywords .= $keyword["name_$lang"].',';
                  }
                  $product_keywords = rtrim($product_keywords, ", ");

                  $Category =  Category::select("name_$lang as name",'id' )
                                       ->where('status',1)->find($product->category_id);

                  $relatedProducts = Product::productsMinimal()
                                     ->where('products.id','!=',$id)
                                     ->where('products.is_bundle',0)
                                     ->limit(5)
                                     ->get();

              $view_data = ['product','Images','Category', 'product_keywords', 'relatedProducts' ];

              if($product->is_bundle)
                return view('Site.products.bundel_details',compact($view_data));
              else
                return view('Site.products.product_details',compact($view_data));
      } 

}
