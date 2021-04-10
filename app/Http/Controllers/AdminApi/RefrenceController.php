<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\vueAdminController;

use Illuminate\Http\Request;

use App\RefrenceCategory;
use App\Refrence;
use App\RefrenceImages;

class RefrenceController extends vueAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->set_model_name('Refrence');

        $this->vars_for_selections = [
           'Categories' => RefrenceCategory::select('id as value','name_en as label')->get()
        ];

        $this->sort_attrs =  [
             'id' , 'name_en as name' , 'position'  , 'status'
        ];

    }//End __construct

    public function show($id)
    {
        $Refrence = Refrence::findOrFail($id);
        $Images = RefrenceImages::select('*','id as cc')->where('Refrence_id',$id)->get();

        return response()->json([
          'status' => 'success',
          'Refrence' => $Refrence,
          'Images' => $Images
        ]);
    }

    public function get_list(Request $request)
    {
           $search = $request->search;
           $category_id = $request->category_id;

           $data = Refrence::select('refrences.*','P_images.image as image')
            ->where(function($q)use($category_id){
                if ($category_id)
                   $q->where('category_id',$category_id);
             })
            ->where(function($q)use($search){
                if ($search)
                {
                   $q->where('refrences.id',$search)
                     ->orWhere('name_en','like','%'.$search.'%')->orWhere('name_ar','like','%'.$search.'%');
                }//End if
             })
             ->leftJoin('refrence_images as P_images',function($j){
                $j->on('P_images.refrence_id','refrences.id')->where('is_main',1);
             })
            ->latest('id')->paginate();
            return collect(['status' => 'success'])->merge($data);
    }

    public function get_Categories()
    {
        return RefrenceCategory::select('id as value','name_en as label')->get();
    }

    public function store(Request $request)
    {
         $validator = \Validator::make($request->all(),[
             'category_id' => 'required',
             'name_en' => 'required',
             'name_ar' => 'required',
             'description_en' => 'required',
             'description_ar' => 'required',
             // 'banner' => 'required|max:2000',
             'colour_en' => 'required',
             'pile_height_en' => 'required',
             'stitch_density_en' => 'required',
             'machine_gauge_en' => 'required',
             'colour_ar' => 'required',
             'pile_height_ar' => 'required',
             'stitch_density_ar' => 'required',
             'machine_gauge_ar' => 'required',
             'images.*' => 'required|max:2000',
             'is_main' => 'required',
         ]);
         if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

         $Refrence = Refrence::create([
             'category_id' => $request->category_id,
             'name_en' => $request->name_en,
             'name_ar' => $request->name_ar,
             'description_en' => $request->description_en,
             'description_ar' => $request->description_ar,
             'colour_en' => $request->colour_en,
             'pile_height_en' => $request->pile_height_en,
             'stitch_density_en' => $request->stitch_density_en,
             'machine_gauge_en' => $request->machine_gauge_en,
             'colour_ar' => $request->colour_ar,
             'pile_height_ar' => $request->pile_height_ar,
             'stitch_density_ar' => $request->stitch_density_ar,
             'machine_gauge_ar' => $request->machine_gauge_ar,
         ]);

         $images_arr = [];
         foreach ($request->images as $key => $image)
         {
            if($key == $request->is_main)
            {
               array_push($images_arr,[
                  'image' => $image,
                  'is_main' => 1
               ]);
            }
            else {
               array_push($images_arr,[
                  'image' => $image,
                  'is_main' => 0
               ]);
            }
         }

         $Refrence->Images()->createMany($images_arr);

         $Refrence->status = 1;
         return response()->json([
           'status' => 'success',
           'data' => $Refrence
         ]);
     }

    public function update_2(Request $request)
    {
      // return $request->all();
          $validator = \Validator::make($request->all(),[
             'id' => 'required',
             'category_id' => 'required',
             'name_en' => 'required',
             'name_ar' => 'required',
             'description_en' => 'required',
             'description_ar' => 'required',
             // 'banner' => 'max:2000',
             'colour_en' => 'required',
             'pile_height_en' => 'required',
             'stitch_density_en' => 'required',
             'machine_gauge_en' => 'required',
             'colour_ar' => 'required',
             'pile_height_ar' => 'required',
             'stitch_density_ar' => 'required',
             'machine_gauge_ar' => 'required',
             'images.*' => 'max:2000',
             'is_main' => '',
         ]);
         if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

         $the_data = [
             'category_id' => $request->category_id,
             'name_en' => $request->name_en,
             'name_ar' => $request->name_ar,
             'description_en' => $request->description_en,
             'description_ar' => $request->description_ar,
             'colour_en' => $request->colour_en,
             'pile_height_en' => $request->pile_height_en,
             'stitch_density_en' => $request->stitch_density_en,
             'machine_gauge_en' => $request->machine_gauge_en,
             'colour_ar' => $request->colour_ar,
             'pile_height_ar' => $request->pile_height_ar,
             'stitch_density_ar' => $request->stitch_density_ar,
             'machine_gauge_ar' => $request->machine_gauge_ar,
         ];

         // if($request->banner){
         //    $the_data['banner'] = $request->banner;
         // }

         $Refrence = Refrence::find($request->id);
         $Refrence->update($the_data);

         RefrenceImages::where('Refrence_id',$request->id)->update(['is_main'=>0]);
         if($request->is_main){
            $update_is_main = RefrenceImages::find($request->is_main);
            if($update_is_main)
               $update_is_main->update(['is_main'=>1]);
         }

         if(isset($request->old_images_ids)){
            RefrenceImages::where('Refrence_id',$request->id)->whereNotIn('id',array_filter($request->old_images_ids))->delete();
         }
         else
            RefrenceImages::where('Refrence_id',$request->id)->delete();


         if(isset($request->images))
         {
            $images_arr = [];
            foreach ($request->images as $key => $image)
            {
               $Refrence->Images()->create([
                  'image' => $image
               ]);
            }
         }

         $check_is_main = RefrenceImages::where('Refrence_id',$request->id)->where('is_main',1)->first();
         if(!$check_is_main){
            $first_Image = RefrenceImages::where('Refrence_id',$request->id)->first();
            if($first_Image)
               $first_Image->update(['is_main'=>1]);
         }

         $Images = RefrenceImages::select('*','id as cc')->where('Refrence_id',$request->id)->get();

         $Refrence->status = 1;
         return response()->json([
           'status' => 'success',
           'Refrence' => $Refrence,
           'Images' => $Images
         ]);
     }

}
