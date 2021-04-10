<?php
namespace App\Http\Controllers\AdminApi;

use Illuminate\Http\Request;
use App\Http\Controllers\vueAdminController;

use App\Product;
use App\ProductImages;

use App\Category;
use App\SubCategory;
use App\ProductKeywords;

class BundelController extends vueAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->set_model_name('Product');

        $this->search_attrs =  [
             'id' , 'name_en' , 'name_ar'
        ];

    }//End __construc

    public function list_without_paginate()
    {
        return Product::select('id' , 'name_en as name' , 'price' , 'position_bundle as  position' , 'status')
                      ->where('is_bundle',1)->orderBy('position_bundle')->get();
    }


    public function show($id)
    {
        $Product = Product::findOrFail($id);
        $BundleProducts = Product::select('products.id as cc','products.id as product_id','products.name_en as name',
                                          'image',\DB::raw("false as showLoder"),\DB::raw("true as isIdCorrect") )
                                 ->leftJoin('product_images',function($q){
                                       $q->on('product_images.product_id','products.id')->where('product_images.is_main',1);
                                  })
                                 ->groupBy('products.id')
                                 ->whereIn('products.id',explode(',', $Product->bundle_products_ids) )
                                 ->get();
        $Keywords = ProductKeywords::select('*','id as cc')->where('product_id',$id)->get();

        return response()->json([
          'status' => 'success',
          'Bundel' => $Product,
          'BundleProducts' => $BundleProducts,
          'Keywords' => $Keywords
        ]);
    }

     public function get_Product_By_Id($id)
     {
         $Product = Product::select('products.id as product_id','name_en as name','image')
                           ->where('is_bundle',0)
                           ->leftJoin('product_images',function($q){
                                $q->on('product_images.product_id','products.id')->where('product_images.is_main',1);
                           })
                           ->groupBy('products.id')
                           ->where('products.id',$id)
                           ->first();

         if($Product)
         {
            return response()->json([
              'status' => 'success',
              'Product' => $Product,
            ]);
         }
         else
         {
           return response()->json([
             'status' => 'Failed',
             'status_message' => 'wrong product id' ,
           ]);
         }
     }


    //---api----
    public function get_list(Request $request)
    {
         $search = $request->search;
         $stock = $request->stock;

         $data = Product::select('products.*' )
           ->where('is_bundle',1)
          ->where(function($q)use($stock){
              if($stock || $stock == '0'  )
                $q->where('products.quantity','<=',$stock);
          })
          ->where(function($q)use($search){
            if ($search)
              $q->where('products.name_en','like','%'.$search.'%')->orWhere('products.name_ar','like','%'.$search.'%')
                ->orWhere('short_description_en','like','%'.$search.'%')->orWhere('short_description_ar','like','%'.$search.'%')
                ->orWhere('description_en','like','%'.$search.'%')->orWhere('description_ar','like','%'.$search.'%')
                ->orWhere('price','like','%'.$search.'%')->orWhere('products.quantity','like','%'.$search.'%')
                ->orWhere('products.id',$search);
          })
          ->groupBy('products.id')
          ->latest('products.id')
          ->paginate();

          foreach ($data as $key => $Product)
          {
              $Product->images = ProductImages::whereIn('product_id', explode(',', $Product->bundle_products_ids) )
                                              ->where('is_main',1)->get();

          }

          return collect(['status' => 'success'])->merge($data);
    }

    public function store(Request $request)
    {
      $data = $request->validate([
          'name_en' => 'required',
          'name_ar' => 'required',
          'short_description_en' => 'required',
          'short_description_ar' => 'required',
          'description_en' => 'required',
          'description_ar' => 'required',
          'price' => 'required',
          'quantity' => 'required',
          'bundle_summary_en' => 'required',
          'bundle_summary_ar' => 'required',
          'bundle_products_ids' => 'required',
          'sap_code' => '',
      ]);

       $Product = Product::create([
           'is_bundle' => 1,
           'name_en' => $request->name_en,
           'name_ar' => $request->name_ar,
           'short_description_en' => $request->short_description_en,
           'short_description_ar' => $request->short_description_ar,
           'description_en' => $request->description_en,
           'description_ar' => $request->description_ar,
           'price' => $request->price,
           'discount_percentage' => 0,
           'old_price' => $request->priceold_price,
           'quantity' => $request->quantity,
           'bundle_summary_en' => $request->bundle_summary_en,
           'bundle_summary_ar' => $request->bundle_summary_ar,
           'bundle_products_ids' => $request->bundle_products_ids,
           'sap_code' => $request->sap_code,
      ]);

      if($request->Keywords_en)
      {
          for ($i=0; $i < count($request->Keywords_en) ; $i++)
          {
              ProductKeywords::create([
                'product_id' => $Product->id ,
                'name_en' => $request->Keywords_en[$i] ,
                'name_ar' => $request->Keywords_ar[$i]
              ]);
          }
      }

      return response()->json([
        'status' => 'success',
        'data' => $Product
      ]);
    }

    //--api--
    public function update(Request $request)
    {
        $data = $request->validate([
          'id' => 'required',
          'name_en' => 'required',
          'name_ar' => 'required',
          'short_description_en' => 'required',
          'short_description_ar' => 'required',
          'description_en' => 'required',
          'description_ar' => 'required',
          'price' => 'required',
          'quantity' => 'required',
          'bundle_summary_en' => 'required',
          'bundle_summary_ar' => 'required',
          'bundle_products_ids' => 'required',
          'sap_code' => '',
        ]);

        $data['old_price'] = $request->price;

        $Product = Product::create($data);

        $Product = Product::findOrFail($request->id);

        $Product->update($data);

           if($request->Keywords_id)
              ProductKeywords::where('product_id',$Product->id)->whereNotIn('id',array_filter($request->Keywords_id))->delete();
           else
              ProductKeywords::where('product_id',$Product->id)->delete();

           if($request->Keywords_en)
           {
               for ($i=0; $i < count($request->Keywords_en) ; $i++)
               {
                   $Keyword_data = [
                     'product_id' => $Product->id ,
                     'name_en' => $request->Keywords_en[$i] ,
                     'name_ar' => $request->Keywords_ar[$i]
                   ];
                   if(isset($request->Keywords_id[$i])) {
                       ProductKeywords::find($request->Keywords_id[$i])->update($Keyword_data);
                   }
                   else {
                       ProductKeywords::create($Keyword_data);
                   }
               }
           }

        $Product->status = 1;
        return response()->json([
          'status' => 'success',
          'Product' => $Product,
        ]);

    }


}
