<?php

namespace App\Http\Controllers\AdminApi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\PagesBanner;

class PagesBannerController extends Controller
{

      public function __construct()
      {
           $this->middleware('verifyAdminApiAuth');
      }

      public function get_list(Request $request)
      {
           $search = $request->search;
           return PagesBanner::
            where(function($q)use($search){
                if ($search)
                  $q->where('page','like','%'.$search.'%')
                    // ->orWhere('title_en','like','%'.$search.'%')->orWhere('title_ar','like','%'.$search.'%')
                    ->orWhere('title','like','%'.$search.'%')
                    ->orWhere('id',$search);
            })
            ->orderBy('position')->paginate();
      }

      public function update(Request $request)
      {
          $validator = \Validator::make($request->all(), [
              'id' => 'required',
              'imagear' => '',
              'imageen' => '',
              'title_en' => '',
              'title_ar' => '',
              'body_en' => '',
              'body_ar' => '',
              'link' => '',
          ]);
          if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

          $item = PagesBanner::findOrFail($request->id);
          $item->update($request->except('_token'));
          return response()->json([
            'status' => 'success',
            'data' => $item
          ]);
      }


}
