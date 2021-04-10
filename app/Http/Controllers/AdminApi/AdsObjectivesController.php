<?php

namespace App\Http\Controllers\AdminApi;

use Illuminate\Http\Request;
use App\Http\Controllers\vueAdminController;

use App\Models\AdsObjectives;
use App\Models\AdsProducts;
use App\Models\AdProductImages;

class AdsObjectivesController extends vueAdminController
{

    public function __construct()
    {
       parent::__construct();
       $this->set_model_name('AdsProducts');

       $this->search_attrs =  [
            'id' , 'name_en' , 'name_ar'
       ];

       // $this->vars_for_selections =  [
       //    'categoiry_subCategory' => $this->get_categoiry_subCategory()
       // ];

       $this->sort_attrs =  [
            'id' , 'name_en as name' , 'position' , 'status'
       ];

       $this->store_attrs =  [
           'category_id' => 'required',
           'sub_category_id' => 'required',
           'name_en' => 'required',
           'name_ar' => 'required',
           'og_description_en' => '',
           'og_description_ar' => '',
       ];

       $this->update_attrs =  [
            'id' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'name_en' => 'required',
            'name_ar' => 'required',
            'og_description_en' => '',
            'og_description_ar' => '',
       ];

    }//End __construc

    /*
     * show Ads Product
     * @param id
     */
    public function show($id)
    {
        $AdsProduct = AdsProducts::findOrFail($id);

        $Images = AdProductImages::select('*','id as cc')->where('ads_product_id',$id)->get();
        // $Keywords = AdProductKeywords::select('*','id as cc')->where('product_id',$id)->get();
        // $PackageBasic = $Product->PackageBasic;
        // $PackageStandard = $Product->PackageStandard;
        // $PackagePremium = $Product->PackagePremium;


        return response()->json([
          'status' => 'success',
          'AdProduct' => $AdsProduct,
          'Images' => $Images,
          // 'Keywords' => $Keywords,
        ]);
    }

    public function AdProductUpdate(Request $request)
    {
        $validator = \Validator::make($request->all(), [
          'id' => 'required',
          // 'provider_id' => 'required',
          // 'name_en' => 'required',
          'name_ar' => 'required',
          'top_description_en' => 'required',
          'top_description_ar' => 'required',
          'description_en' => 'required',
          'description_ar' => 'required',
          'price' => 'required',
          // 'is_available' => '',
          'youtube_link' => '',
          'images.*' => 'max:400'
        ]);
        if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

        $the_data = [
          // 'name_en' => $request->name_en,
          'name_ar' => $request->name_ar,
          'top_description_en' => $request->top_description_en,
          'top_description_ar' => $request->top_description_ar,
          'description_en' => $request->description_en,
          'description_ar' => $request->description_ar,
          'is_available' => ($request->is_available == 'true' || $request->is_available == 1 ),
          'youtube_link' => $request->youtube_link,
        ];

        $AdsProducts = AdsProducts::findOrFail($request->id);

        $AdsProducts->update($the_data);

        AdProductImages::where('ads_product_id',$request->id)->update(['is_main'=>0]);
        if($request->is_main){
          $update_is_main = AdProductImages::find($request->is_main);
          if($update_is_main)
             $update_is_main->update(['is_main'=>1]);
        }
        if(isset($request->old_images_ids)){
          AdProductImages::where('ads_product_id',$request->id)->whereNotIn('id',array_filter($request->old_images_ids))->delete();
        }
        else
          AdProductImages::where('ads_product_id',$request->id)->delete();


        if(isset($request->images))
        {
             $images_arr = [];
             foreach ($request->images as $key => $image)
             {
                $AdsProducts->Images()->create([
                    'image' => $image
                ]);
             }
        }

        $check_is_main = AdProductImages::where('ads_product_id',$request->id)->where('is_main',1)->first();
        if(!$check_is_main){
          $first_Image = AdProductImages::where('ads_product_id',$request->id)->first();
          if($first_Image)
             $first_Image->update(['is_main'=>1]);
        }

          $Images = AdProductImages::select('*','id as cc')->where('ads_product_id',$request->id)->get();

         // if($request->Keywords_id)
         //    ProductKeywords::where('product_id',$Product->id)->whereNotIn('id',array_filter($request->Keywords_id))->delete();
         // else
         //    ProductKeywords::where('product_id',$Product->id)->delete();
         //
         //   if($request->Keywords_en)
         //   {
         //       for ($i=0; $i < count($request->Keywords_en) ; $i++)
         //       {
         //           $Keyword_data = [
         //             'product_id' => $Product->id ,
         //             'name_en' => $request->Keywords_en[$i] ,
         //             'name_ar' => $request->Keywords_ar[$i]
         //           ];
         //           if(isset($request->Keywords_id[$i])) {
         //               ProductKeywords::find($request->Keywords_id[$i])->update($Keyword_data);
         //           }
         //           else {
         //               ProductKeywords::create($Keyword_data);
         //           }
         //       }
         //   }

        $AdsProducts->status = 1;
        return response()->json([
          'status' => 'success',
          'Product' => $AdsProducts,
          'Images' => $Images,
        ]);
    }


    public function AdProduct_showORhide($id)
    {
         $item = AdsProducts::findOrFail($id);
         if( $item->status )
         {
            $item->update(['status' => '0']);
            $case = 0;
         }
         else
         {
            $item->update(['status' => '1']);
            $case = 1;
         }

         return response()->json([
             'status' => 'success',
             'case' => $case
         ]);
    }
    // public function get_categoiry_subCategory()
    // {
    //     $categoiry_subCategory = Category::select('name_en as label','id as value')->get();
    //     foreach ($categoiry_subCategory as $key => $categoiry)
    //     {
    //        $categoiry->subCategoiry = SubCategory::select('name_en as label','id as value')
    //                                         ->where('category_id',$categoiry->value)->get();
    //     }
    //
    //     return $categoiry_subCategory;
    // }

    //---api----
    public function get_list(Request $request)
    {
         $search = $request->search;
         $Category_id = $request->Category_id;
         $sub_category_id = $request->SubCategory_id;
         return AdsObjectives::with('Products')
          ->where(function($q)use($Category_id){
             if($Category_id)
                $q->where('brands.category_id',$Category_id);
          })
          ->where(function($q)use($search){
              if ($search)
                $q->where('brands.name_en','like','%'.$search.'%')
                  ->orWhere('brands.name_ar','like','%'.$search.'%')->orWhere('brands.id',$search);
          })
          ->latest('id')->paginate(20);
    }

    public function brand_switchinHomePage($id)
    {
         $item = Brand::findOrFail($id);
         $check = HomePage::where('type','brand')->where('relation_id',$id)->first();
         if(!$check)
         {
            HomePage::create([
              'type' => 'brand',
              'relation_id' => $id ,
              'position' =>  HomePage::max('position') + 1
            ]);
         }

         return response()->json([
             'status' => 'success',
             'case' => 1
         ]);
    }


}
