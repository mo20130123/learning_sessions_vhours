<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Product;
use App\Category;
use App\SubCategory;
use App\CategoryBanners;

class CategoryController extends Controller
{
   public function __construct()
    {
        $this->middleware('MemberNotRequiredJWTAndLangAndRate') ;
    }


    public function get_Category_info_by_id(Request $request,$Category_id)
    {
      $lang = $request->lang;
      $AuthMember_id = $request->MemberID;

      $Category =  Category::select("name_$lang as name",'id',"icon")
                         ->where('status',1)->findOrFail($Category_id);
      $main_images = CategoryBanners::select('id' ,"image_$lang as image",'link')
                                  ->where('category_id',$Category->id)->where('status',1)->orderBy('position')
                                  ->get();
      $SubCategories = SubCategory::select( "name_$lang as name",'id' )
                                         ->where('category_id',$Category->id)->where('status',1)->orderBy('position')->get();
         return response()->json([
             'status' => 'success',
             'Category' => $Category ,
             'banners_ads' => $main_images ,
             'SubCategories' => $SubCategories ,
         ]);
    }

    public function get_products_by_subCategoryId(Request $request)
    {
        $validator = \Validator::make($request->all(), [
             'category_id' => 'required',
             'subCategory_id' => 'required',
             'min_price' => '',
             'max_price' => '',
             'sort' => '',
        ]);
        if ($validator->fails()) {
            return response()->json([ 'status' => 'notValid' ,'status_message' => __('api.notValid') , 'missing_data' => $validator->messages() ]);
        }

        $lang = $request->lang;
        $min_price = $request->min_price;
        $max_price = $request->max_price;
        $sort = $request->sort;
        $orderWith='products.position';
        $orderby='ASC';

        if($sort)
        {
            switch ($sort)
            {
              case 'name':
                  $orderWith='products.name_'.$lang;
                  $orderby='ASC';
                break;
              case 'lowerPrice':
                  $orderWith='products.price';
                  $orderby='ASC';
                break;
              case 'higherPrice':
                  $orderWith='products.price';
                  $orderby='DESC';
                break;
            }
        }

        $Category =  Category::select("name_$lang as name",'id',"banner_$lang as banner")
                           ->where('status',1)->findOrFail($request->category_id);

        $AuthMember_id = $request->MemberID;
        $Products = Product::productsMinimal($AuthMember_id)
               ->where('products.is_bundle',0)
               ->where('products.sub_category_id',$request->subCategory_id)
               ->where(function($q)use($min_price,$max_price){
                   if($min_price){
                      $q->where('price','>=',$min_price);
                   }
                   if($max_price){
                      $q->where('price','<=',$max_price);
                   }
               })
               // ->orderByRaw('FIELD(products.is_chef_rec , 1 ) Desc')
               ->orderBy($orderWith,$orderby)
               ->paginate(30);
       return collect(['status' => 'success','banner'=>$Category->banner])->merge($Products);
    }
}
