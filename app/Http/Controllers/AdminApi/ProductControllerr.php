<?php
namespace App\Http\Controllers\AdminApi;

use Illuminate\Http\Request;
use App\Http\Controllers\vueAdminController;

use App\Models\Product;
use App\Models\ProductImages;

use App\Models\Category;
use App\Models\ProductKeywords;

use App\Imports\StockImport;
use Maatwebsite\Excel\Facades\Excel;

class ProductControllerr extends vueAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->set_model_name('Product');

        $this->search_attrs =  [
             'id' , 'name_en' , 'name_ar'
        ];

        $this->vars_for_selections =  [
           'categoiry_BaseProducts' =>  self::get_categoiry_subCategory(),
           'providers' =>  \App\Models\Provider::select('name_en as label','id as value')->get()
        ];

    }//End __construc

    public function list_without_paginate($classification = null)
    {
      return Product::select('id' , 'name_en as name' , 'position' , 'status')
                    ->where('is_bundle',0)
                    ->orderBy('position')->get();
    }

    public function show($id)
    {
        $Product = Product::findOrFail($id);

        $Images = ProductImages::select('*','id as cc')->where('product_id',$id)->get();
        $Keywords = ProductKeywords::select('*','id as cc')->where('product_id',$id)->get();
        $PackageBasic = $Product->PackageBasic ?? (object)[];
        $PackageStandard = $Product->PackageStandard ?? (object)[];
        $PackagePremium = $Product->PackagePremium ?? (object)[];
        $PackageBundle = $Product->PackageBundle ?? (object)[];

         $Product->Pakage_Basic_items_en = $Product->PackageBasic ? $Product->PackageBasic->remaining_text_en : '[]';
         $Product->Pakage_Basic_items_ar = $Product->PackageBasic ? $Product->PackageBasic->remaining_text_ar : '[]';

         $Product->Pakage_Standard_items_en = $Product->PackageStandard ? $Product->PackageStandard->remaining_text_en : '[]';
         $Product->Pakage_Standard_items_ar = $Product->PackageStandard ? $Product->PackageStandard->remaining_text_ar : '[]';

         $Product->Pakage_Premium_items_en = $Product->PackagePremium ? $Product->PackagePremium->remaining_text_en : '[]';
         $Product->Pakage_Premium_items_ar = $Product->PackagePremium ? $Product->PackagePremium->remaining_text_ar : '[]';

         $Product->Pakage_Bundle_items_en = $Product->PackageBundle ? $Product->PackageBundle->remaining_text_en : '[]';
         $Product->Pakage_Bundle_items_ar = $Product->PackageBundle ? $Product->PackageBundle->remaining_text_ar : '[]';

        return response()->json([
          'status' => 'success',
          'Product' => $Product,
          'Images' => $Images,
          'Keywords' => $Keywords,
          'Basic' => $PackageBasic,
          'Standard' => $PackageStandard,
          'Premium' => $PackagePremium,
          'Bundle' => $PackageBundle
        ]);
    }

     public function get_categoiry_subCategory()
     {
         $categoiry_BaseProducts = Category::select('name_en as label','id as value')->get();
         foreach ($categoiry_BaseProducts as $key => $categoiry)
         {
             $categoiry->BaseProducts = \App\Models\BaseProduct::select('name_en as label','id as value')
                                              ->where('category_id',$categoiry->value)->get();
         }

         return $categoiry_BaseProducts;
     }




    //---api----
    public function get_list(Request $request)
    {

         $search = $request->search;
         $category_id = $request->category_id;
         $base_product_id  = $request->base_product_id ;
         $provider_id  = $request->provider_id ;
         $availability = $request->availability;
         $type = $request->type;
         // return Product::paginate();
         $data = Product::select('products.*', 'P_images.image as image' ,
               "categories.name_en as category_name","base_products.name_en as sub_category_name"
           )

          ->where(function($q)use($category_id,$base_product_id,$provider_id,$availability,$type){
              if($category_id){
                  $q->where('products.category_id',$category_id);
              }
              if($base_product_id){
                  $q->where('products.base_product_id',$base_product_id);
              }
              if($provider_id){
                  $q->where('products.provider_id',$provider_id);
              }
              if($availability)
              {
                  switch ($availability)
                  {
                    case 'is available':
                          $q->where('products.is_available',1);
                      break;
                    case 'not available':
                          $q->where('products.is_available',0);
                      break;
                  }
              }
              if($type)
              {
                  switch ($type)
                  {
                    case 'product':
                          $q->where('products.is_bundle',0);
                      break;
                    case 'bundle':
                          $q->where('products.is_bundle',1);
                      break;
                  }
              }
          })
          ->where(function($q)use($search){
            if ($search)
              $q->where('products.name_en','like','%'.$search.'%')->orWhere('products.name_ar','like','%'.$search.'%')
                ->orWhere('short_description_en','like','%'.$search.'%')->orWhere('short_description_ar','like','%'.$search.'%')
                ->orWhere('description_en','like','%'.$search.'%')->orWhere('description_ar','like','%'.$search.'%')
                ->orWhere('products.id',$search);
          })
          ->leftJoin('product_images as P_images',function($j){
             $j->on('P_images.product_id','products.id')->where('is_main',1);
          })
          ->leftJoin('categories','categories.id','products.category_id')
          ->leftJoin('base_products','base_products.id','products.base_product_id')
          ->groupBy('products.id')
          ->latest('products.id')
          ->paginate();
          return collect(['status' => 'success'])->merge($data);
    }

    public function store(Request $request)
    {
      // return $request->all();
        $validator = \Validator::make($request->all(), [
          'category_id' => 'required',
          'base_product_id' => 'required',
          'provider_id' => 'required',
          'name_en' => 'required',
          'name_ar' => 'required',
          'short_description_en' => '',
          'short_description_ar' => '',
          'description_en' => 'required',
          'description_ar' => 'required',
          // 'discount_percentage' => 'required',
          'is_available' => '',
          'is_bundle' => '',
          'images.*' => 'max:400'
        ]);
        if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

        // parse to bool
        $is_bundle = filter_var($request->is_bundle, FILTER_VALIDATE_BOOLEAN);
        $have_BasicPakage = filter_var($request->have_BasicPakage, FILTER_VALIDATE_BOOLEAN);
        $have_StandardPakage = filter_var($request->have_StandardPakage, FILTER_VALIDATE_BOOLEAN);
        $have_PremiumPakage = filter_var($request->have_PremiumPakage, FILTER_VALIDATE_BOOLEAN);

        $the_data = [
          'category_id' => $request->category_id,
          'base_product_id' => $request->base_product_id,
          'provider_id' => $request->provider_id,
          'name_en' => $request->name_en,
          'name_ar' => $request->name_ar,
          'short_description_en' => $request->short_description_en,
          'short_description_ar' => $request->short_description_ar,
          'description_en' => $request->description_en,
          'description_ar' => $request->description_ar,
          'requirements_en' => $request->requirements_en,
          'requirements_ar' => $request->requirements_ar,
          'offer_percentage' => $request->offer_percentage,
          'is_available' => ($request->is_available == 'true' || $request->is_available == 1),
          'youtube_link' => $request->youtube_link,
          'is_bundle' => $is_bundle ? 1 : 0,
          'have_BasicPakage' => $have_BasicPakage ? 1 : 0,
          'have_StandardPakage' => $have_StandardPakage ? 1 : 0,
          'have_PremiumPakage' => $have_PremiumPakage ? 1 : 0
        ];

      $Product = Product::create($the_data);

      $images_arr = [];
      foreach ($request->images as $key => $image)
      {
         if($key == $request->is_main)
         {
            array_push($images_arr,[
               'product_id' => $Product->id ,
               'image' => $image,
               'is_main' => 1
            ]);
         }
         else {
            array_push($images_arr,[
               'product_id' => $Product->id ,
               'image' => $image,
               'is_main' => 0
            ]);
         }
      }

      $Product->Images()->createMany($images_arr);

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

      if($have_BasicPakage)
        $Product->PackageBasic()->create([
            'price' => $request->Pakage_Basic_price,
            'days' => $request->Pakage_Basic_day,
            'modifications' => $request->Pakage_Basic_modification,
            'remaining_text_en' => $request->Pakage_Basic_items_en,
            'remaining_text_ar' => $request->Pakage_Basic_items_ar,
        ]);

      if($have_StandardPakage)
        $Product->PackageStandard()->create([
            'price' => $request->Pakage_Standard_price,
            'days' => $request->Pakage_Standard_day,
            'modifications' => $request->Pakage_Standard_modification,
            'remaining_text_en' => $request->Pakage_Standard_items_en,
            'remaining_text_ar' => $request->Pakage_Standard_items_ar,
        ]);

      if($have_PremiumPakage)
        $Product->PackagePremium()->create([
            'price' => $request->Pakage_Premium_price,
            'days' => $request->Pakage_Premium_day,
            'modifications' => $request->Pakage_Premium_modification,
            'remaining_text_en' => $request->Pakage_Premium_items_en,
            'remaining_text_ar' => $request->Pakage_Premium_items_ar,
        ]);

      if($is_bundle)
        $Product->PackageBundle()->create([
            'price' => $request->Pakage_Bundle_price,
            'days' => $request->Pakage_Bundle_day,
            'modifications' => $request->Pakage_Bundle_modification,
            'remaining_text_en' => $request->Pakage_Bundle_items_en,
            'remaining_text_ar' => $request->Pakage_Bundle_items_ar,
        ]);

      return response()->json([
        'status' => 'success',
        'data' => $Product
      ]);
    }

    //--api--
    public function update(Request $request)
    {
          // return $request->all();
        $validator = \Validator::make($request->all(), [
          'id' => 'required',
          'category_id' => 'required',
          'base_product_id' => 'required',
          'provider_id' => 'required',
          'name_en' => 'required',
          'name_ar' => 'required',
          'short_description_en' => '',
          'short_description_ar' => '',
          'description_en' => 'required',
          'description_ar' => 'required',
          'offer_percentage' => 'required',
          // 'discount_percentage' => 'required',
          'is_available' => '',
          'is_bundle' => '',
          'images.*' => 'max:400'
        ]);
        if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

        // parse to bool
        $is_bundle = filter_var($request->is_bundle, FILTER_VALIDATE_BOOLEAN);
        $have_BasicPakage = filter_var($request->have_BasicPakage, FILTER_VALIDATE_BOOLEAN);
        $have_StandardPakage = filter_var($request->have_StandardPakage, FILTER_VALIDATE_BOOLEAN);
        $have_PremiumPakage = filter_var($request->have_PremiumPakage, FILTER_VALIDATE_BOOLEAN);

        $the_data = [
          'category_id' => $request->category_id,
          'base_product_id' => $request->base_product_id,
          'provider_id' => $request->provider_id,
          'name_en' => $request->name_en,
          'name_ar' => $request->name_ar,
          'short_description_en' => $request->short_description_en,
          'short_description_ar' => $request->short_description_ar,
          'description_en' => $request->description_en,
          'description_ar' => $request->description_ar,
          'requirements_en' => $request->requirements_en,
          'requirements_ar' => $request->requirements_ar,
          'offer_percentage' => $request->offer_percentage,
          'is_available' => ($request->is_available == 'true' || $request->is_available == 1),
          'youtube_link' => $request->youtube_link,
          'is_bundle' => $is_bundle ? 1 : 0,
          'have_BasicPakage' => $have_BasicPakage ? 1 : 0,
          'have_StandardPakage' => $have_StandardPakage ? 1 : 0,
          'have_PremiumPakage' => $have_PremiumPakage ? 1 : 0
        ];

        $Product = Product::findOrFail($request->id);

        $Product->update($the_data);

        ProductImages::where('product_id',$request->id)->update(['is_main'=>0]);
        if($request->is_main){
          $update_is_main = ProductImages::find($request->is_main);
          if($update_is_main)
             $update_is_main->update(['is_main'=>1]);
        }
        if(isset($request->old_images_ids)){
          ProductImages::where('product_id',$request->id)->whereNotIn('id',array_filter($request->old_images_ids))->delete();
        }
        else
          ProductImages::where('product_id',$request->id)->delete();


        if(isset($request->images))
        {
             $images_arr = [];
             foreach ($request->images as $key => $image)
             {
                $Product->Images()->create([
                    'image' => $image
                ]);
             }
        }

        $check_is_main = ProductImages::where('product_id',$request->id)->where('is_main',1)->first();
        if(!$check_is_main){
          $first_Image = ProductImages::where('product_id',$request->id)->first();
          if($first_Image)
             $first_Image->update(['is_main'=>1]);
        }

        $Images = ProductImages::select('*','id as cc')->where('product_id',$request->id)->get();

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

           if($have_BasicPakage)
           {
               $arra_data = [
                   'price' => $request->Pakage_Basic_price,
                   'days' => $request->Pakage_Basic_day,
                   'modifications' => $request->Pakage_Basic_modification,
                   'remaining_text_en' => $request->Pakage_Basic_items_en,
                   'remaining_text_ar' => $request->Pakage_Basic_items_ar,
               ];

               if($Product->PackageBasic)
                  $Product->PackageBasic()->update($arra_data);
               else
                  $Product->PackageBasic()->create($arra_data);
           }

           if($have_StandardPakage)
           {
               $arra_data = [
                   'price' => $request->Pakage_Standard_price,
                   'days' => $request->Pakage_Standard_day,
                   'modifications' => $request->Pakage_Standard_modification,
                   'remaining_text_en' => $request->Pakage_Standard_items_en,
                   'remaining_text_ar' => $request->Pakage_Standard_items_ar,
               ];

               if($Product->PackageStandard)
                  $Product->PackageStandard()->update($arra_data);
               else
                  $Product->PackageStandard()->create($arra_data);
           }

           if($have_PremiumPakage)
           {
              $arra_data = [
                  'price' => $request->Pakage_Premium_price,
                  'days' => $request->Pakage_Premium_day,
                  'modifications' => $request->Pakage_Premium_modification,
                  'remaining_text_en' => $request->Pakage_Premium_items_en,
                  'remaining_text_ar' => $request->Pakage_Premium_items_ar,
              ];

              if($Product->PackagePremium)
                 $Product->PackagePremium()->update($arra_data);
              else
                 $Product->PackagePremium()->create($arra_data);
           }

           if($is_bundle)
           {
              $arra_data = [
                  'price' => $request->Pakage_Bundle_price,
                  'days' => $request->Pakage_Bundle_day,
                  'modifications' => $request->Pakage_Bundle_modification,
                  'remaining_text_en' => $request->Pakage_Bundle_items_en,
                  'remaining_text_ar' => $request->Pakage_Bundle_items_ar,
              ];

              if($Product->PackageBundle)
                 $Product->PackageBundle()->update($arra_data);
              else
                 $Product->PackageBundle()->create($arra_data);
           }

        $Product->status = 1;
        return response()->json([
          'status' => 'success',
          'Product' => $Product,
          'Images' => $Images,
        ]);

    }



    public function switch_is_new($id)
    {
         $item = Product::findOrFail($id);
         if( $item->is_new )
         {
            $item->update(['is_new' => '0']);
            $case = 0;
         }
         else
         {
            $item->update(['is_new' => '1']);
            $case = 1;
         }

         return response()->json([
             'status' => 'success',
             'case' => $case
         ]);
    }

    public function updateStockWithExcel(Request $request)
    {
        $validator = \Validator::make($request->all(), [
          'excel_file' => 'required',
        ]);
        if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }


            $fileName = 'excel_stock_file_'.rand(11111,99999).'.'.$request->excel_file->getClientOriginalExtension(); // renameing image
            $destinationPath = public_path('excel_stock_file');
            $request->excel_file->move($destinationPath, $fileName); // uploading file to given path

               $filePath = $destinationPath.'/'.$fileName;
           Excel::import(new StockImport, $filePath);

           \File::delete($filePath);

         return response()->json([
             'status' => 'success',
         ]);
    }

    public function list_products_by_category_id($category_id)
    {
      return Product::select('id' , 'name_en as name' , 'position' ,'price', 'status')
                    ->where('sub_category_id',$category_id)
                    ->orderBy('position')->get();
    }

    public function updateRowsPositionWithclassification(Request $request)
    {
          $validator = \Validator::make($request->all(), [
              'postionArray' => 'required',
              'classification' => 'required',
          ]);
          if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

          $DB_row_name = null;
          switch ($request->classification)
          {
            case 'chef':
                $DB_row_name = 'position_chef';
              break;
            case 'new':
                $DB_row_name = 'position_new';
              break;
            case 'discount':
                $DB_row_name = 'position_discount';
              break;
            case 'bundle':
                $DB_row_name = 'position_bundle';
              break;
          }

          foreach($request->postionArray as $key => $value)
          {
              $this->myClass::find($value)->update([
                $DB_row_name => (1+$key)
              ]);
          }
          return response()->json([
            'status' => 'success',
          ]);
    }



}
