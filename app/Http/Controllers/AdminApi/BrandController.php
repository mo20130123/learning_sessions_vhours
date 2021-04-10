<?php

namespace App\Http\Controllers\AdminApi;

use Illuminate\Http\Request;
use App\Http\Controllers\vueAdminController;

use App\Brand;
use App\Category;
use App\SubCategory;
use App\HomePage;

class BrandController extends vueAdminController
{

    public function __construct()
    {
       parent::__construct();
       $this->set_model_name('Brand');

       $this->search_attrs =  [
            'id' , 'name_en' , 'name_ar'
       ];

       $this->vars_for_selections =  [
          'categoiry_subCategory' => $this->get_categoiry_subCategory()
       ];

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


    public function get_categoiry_subCategory()
    {
        $categoiry_subCategory = Category::select('name_en as label','id as value')->get();
        foreach ($categoiry_subCategory as $key => $categoiry)
        {
           $categoiry->subCategoiry = SubCategory::select('name_en as label','id as value')
                                            ->where('category_id',$categoiry->value)->get();
        }

        return $categoiry_subCategory;
    }

    //---api----
    public function get_list(Request $request)
    {
         $search = $request->search;
         $Category_id = $request->Category_id;
         $sub_category_id = $request->SubCategory_id;
         return Brand::select("brands.*","categories.name_en as cat_name","sub_categories.name_en as sub_cat_name")
          ->where(function($q)use($Category_id){
             if($Category_id)
                $q->where('brands.category_id',$Category_id);
          })
          ->where(function($q)use($sub_category_id){
              if($sub_category_id)
                 $q->where('brands.sub_category_id',$sub_category_id);
          })
          ->where(function($q)use($search){
              if ($search)
                $q->where('brands.name_en','like','%'.$search.'%')
                  ->orWhere('brands.name_ar','like','%'.$search.'%')->orWhere('brands.id',$search);
          })
          ->join('categories','categories.id','brands.category_id')
          ->join('sub_categories','sub_categories.id','brands.sub_category_id')
          ->latest('brands.id')->paginate(20);
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
