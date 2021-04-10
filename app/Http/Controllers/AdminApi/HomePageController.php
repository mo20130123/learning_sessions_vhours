<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\HomePage;
use DB;

class HomePageController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index()
    {
        return view('Admin.HomePage.index');
    }

    //---api----
    public function get_list(Request $request)
    {
         return HomePage::select('*','home_page.id as id','home_page.status as status'
              , DB::raw("IF(home_page.type='brand',brands.name_en,sub_categories.name_en) as name")
              , DB::raw("IF(home_page.type='brand',
                    CONCAT('".asset('images/Brand/BannerEn')."/',brands.banner_en),
                    CONCAT('".asset('images/Category/BannerEn')."/',sub_categories.banner_en)
                  ) as image")
              )
            ->leftJoin('brands',function($join){
               $join->on('home_page.relation_id','brands.id')->where('home_page.type', 'brand');
            })
            ->leftJoin('sub_categories',function($join){
               $join->on('home_page.relation_id','sub_categories.id')->where('home_page.type', 'subCategory');
            })
            ->orderBy('home_page.position')->paginate();
    }

    public function updateRowsPosition(Request $request)
    {
          $validator = \Validator::make($request->all(), [
              'postionArray' => 'required',
          ]);
          if ($validator->fails()) { return response()->json([ 'state' => 'notValid' , 'data' => $validator->messages() ]);  }

          foreach($request->postionArray as $key => $value)
          {
              HomePage::find($value)->update([
                'position' => (1+$key)
              ]);
          }
          return response()->json([
            'status' => 'success',
          ]);
    }


    //--api--
    public function showORhide($id)
    {
         $item = HomePage::findOrFail($id);
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

    //--api--
    public function destroy($id)
    {
         try {
           $deleted = HomePage::destroy($id);
         } catch (\Exception $e) {
           return 'false';
         }
         return 'true';
    }

}
